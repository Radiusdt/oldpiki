<?php
namespace app\schedule\components\controllers;

use app\schedule\components\CronConfigBuilder;
use yii\console\Controller;

class CrontabController extends Controller
{
    public function actionIndex()
    {
        $commands = (new CronConfigBuilder())->create();
        file_put_contents(\Yii::getAlias('@app/runtime/crontab.cron'), $commands);

        echo $commands;
    }
}
