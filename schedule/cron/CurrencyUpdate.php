<?php
namespace app\schedule\cron;

use Yii;
use app\schedule\components\Cron;
use app\schedule\components\Time;
class CurrencyUpdate extends Cron
{
    public function time()
    {
        return [new Time('0', '1', '*', '*', '*')];
    }

    public $commandName = 'currency';
    public $commandAction = 'update';
}