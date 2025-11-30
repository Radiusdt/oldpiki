<?php
namespace app\schedule\components\controllers;

use app\components\queue\Bernard;
use app\schedule\components\SupervisorConfigBuilder;
use yii\console\Controller;

class QueueController extends Controller
{

    public function actionIndex()
    {
        echo 'Command list: ' . PHP_EOL;
        foreach ((new SupervisorConfigBuilder())->getCommandList() as $command) {
            echo ' - ' . $command . PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function actionProcess($queue, $amount = null, $stopOnEmpty = false)
    {
        //try {
            $namespaces = explode('/', $queue);
            $queueName = $namespaces[count($namespaces) - 1];
            unset($namespaces[count($namespaces) - 1]);
            $words = explode('_', $queueName);
            foreach ($words as &$word) {
                $word = ucfirst($word);
            }
            $className = '\app\schedule\consumers\\' . (empty($namespaces) ? '' : (implode('\\', $namespaces) . '\\')) . implode('', $words) . 'Consumer';
            Bernard::consume($queue, $className, $stopOnEmpty, $amount);
        //} catch (Exception $exception) {
        //    echo $exception->getMessage();
        //}
    }

    public function actionClear($queue)
    {
        Bernard::dropQueue($queue);
    }

    public function actionPush($queue, $message)
    {
        $data = json_decode($message, true);
        $commands = (new SupervisorConfigBuilder())->readSchedule();
        if (isset($commands[$queue])) {
            $className = $commands[$queue]->defaultMessageClass;
            if (!empty($className)) {
                $message = new $className;
                foreach ($data as $key => $value) {
                    $message->$key = $value;
                }
                Bernard::produce($queue, $message);
                return;
            }
        }
        Bernard::produce($queue, json_decode($message, true));
    }

    public function actionPop($queue)
    {

    }

    public function actionRun($queue, $message)
    {
        Bernard::run($queue, json_decode($message, true));
    }

    public function actionSupervisor()
    {
        echo (new SupervisorConfigBuilder())->create();
    }
}
