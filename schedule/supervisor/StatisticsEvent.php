<?php
namespace app\schedule\supervisor;

use app\schedule\components\Supervisor;
use app\schedule\consumers\StatisticsConsumer;

class StatisticsEvent extends Supervisor
{
    public $commandClass = StatisticsConsumer::class;

    public $parallelProcessAmount = 1;

    public $defaultMessageClass = \app\schedule\messages\Statistics::class;

    public $description = 'Store event and track statistics';
}