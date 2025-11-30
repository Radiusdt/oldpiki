<?php
namespace app\components\queue;

use app\schedule\consumers\AbstractConsumer;
use Bernard\Consumer;
use Bernard\Driver\Redis\Driver;
use Bernard\EventListener;
use Bernard\Message\PlainMessage;
use Bernard\Producer;
use Bernard\QueueFactory\PersistentFactory;
use Bernard\Router\ReceiverMapRouter;
use Bernard\Serializer;
use cheatsheet\Time;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Bernard
{
    const MAX_WORKER_TIME = 600; //10 minutes, to avoid memory leak

    private static function prepareQueueName($queue)
    {
        return \Yii::$app->id . ':' . $queue;
    }

    public static function produce($queue, $message)
    {
        self::getProducer()->produce(new PlainMessage(self::prepareQueueName($queue), ['data' => serialize($message)]));
    }

    public static function consume($queue, $className, $stopWhenEmpty = false, $maxMessages = null)
    {
        $queues = self::getQueueFactory();
        self::getConsumer(self::prepareQueueName($queue), $className)->consume($queues->create(self::prepareQueueName($queue)), [
            'max-runtime' => $stopWhenEmpty ? Time::SECONDS_IN_AN_HOUR : self::MAX_WORKER_TIME,
            'max-messages' => $maxMessages,
            'stop-when-empty' => $stopWhenEmpty,
            'stop-on-error' => true,
        ]);
    }

    public static function run($queue, $message)
    {
        $message = unserialize($message)['data'];
        $namespaces = explode('/', $queue);
        $queueName = $namespaces[count($namespaces) - 1];
        unset($namespaces[count($namespaces) - 1]);

        $words = explode('_', $queueName);
        foreach ($words as &$word) {
            $word = ucfirst($word);
        }
        $className = '\app\commands\consumers\\' . (empty($namespaces) ? '' : (implode('\\', $namespaces) . '\\')) . implode('', $words) . 'Consumer';
        /**
         * @var AbstractConsumer $consumer
         */
        $consumer = new $className;
        $consumer->process($message);
    }

    private static function getConnect()
    {
        $redis = new \Redis();
        $redis->connect(\Yii::$app->redis->hostname);
        $redis->setOption(\Redis::OPT_PREFIX, 'bernard:');
        return $redis;
    }

    private static function getDriver()
    {
        return new Driver(self::getConnect());
    }

    public static function dropQueue($id)
    {
        self::getDriver()->removeQueue(self::prepareQueueName($id));
    }

    public static function peekQueue($id, $index = 0, $limit = 20)
    {
        return self::getDriver()->peekQueue(self::prepareQueueName($id), $index, $limit);
    }

    public static function countQueue($id)
    {
        return self::getDriver()->countMessages(self::prepareQueueName($id));
    }

    public static function createQueue($id)
    {
        self::getDriver()->createQueue($id);
    }

    public static function listQueues()
    {
        return self::getDriver()->listQueues();
    }

    private static function getProducer()
    {
        return new Producer(self::getQueueFactory(), new EventDispatcher());
    }

    private static function getQueueFactory()
    {
        //REPLACE ERROR
        // PersistentQueue::count() :int
        return new PersistentFactory(self::getDriver(), self::getSerializer());
    }

    private static function getSerializer()
    {
        return new Serializer();
    }

    private static function getConsumer($queue, $className)
    {
        return new Consumer(new ReceiverMapRouter([
            $queue => new $className
        ]), self::getEventDispatcher());
    }

    private static function getEventDispatcher()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new ErrorLogger());
        $dispatcher->addSubscriber(new EventListener\FailureSubscriber(self::getProducer()));
        return $dispatcher;
    }

}