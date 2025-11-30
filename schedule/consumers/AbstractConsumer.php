<?php
namespace app\schedule\consumers;

use Bernard\Message;
use Bernard\Receiver;
use yii\base\InvalidConfigException;

abstract class AbstractConsumer implements Receiver
{
    /**
     * Receives and handles a message.
     *
     * @param Message\PlainMessage $message
     * @throws InvalidConfigException
     */
    public function receive(Message $message)
    {
        $this->addLogTarget($message);
        try {
            $data = $this->prepareMessage($message->all());
            \Yii::info(json_encode($data), $this->logFileName($message));

            $this->process($data);
        } catch (\Exception $exception) {
            echo $exception->getTraceAsString();
            \Yii::info(json_encode($exception), $this->logFileName($message));

            throw $exception;
        }
    }

    private function prepareMessage($message)
    {
        if (isset($message['data'])) {
            return unserialize($message['data']);
        }
        return $message;
    }

    public function addLogTarget(Message $message)
    {
        \Yii::$app->log->targets[] = [
            'class'  => 'app\components\LogFileTarget',
            'levels' => ['info'],
            'categories' => ['consumer_' . $this->logFileName($message)],
            'logVars' => [],
            'traceLevel' => 0,
            'exportInterval' => 10,
            'logFile' => '@runtime/logs/consumer_' . $this->logFileName($message) . '.log',
            'maxLogFiles' => 30,
        ];
        \Yii::$app->log->init();
    }

    public static function stripQueueName($queue)
    {
        return str_replace(\Yii::$app->id . ':', '', $queue);
    }

    public function logFileName(Message $message)
    {
        return 'consumer_' . self::stripQueueName($message->getName());
    }

    abstract public function process($data);
}