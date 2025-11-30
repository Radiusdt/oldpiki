<?php
namespace app\schedule\components;

use app\components\queue\Bernard;

abstract class Supervisor
{
    public $commandName = 'queue';
    public $commandAction = 'process';
    public $commandClass;

    public $defaultMessageClass = false;

    public $groupName = 'common';

    public $parallelProcessAmount = 1;

    public $runAsSuperuser = false;

    public $description;

    public function getArguments()
    {
        return $this->queueName();
    }

    public function queueName()
    {
        $reflect = new \ReflectionClass($this->commandClass);

        $name = str_replace('Consumer', '', $reflect->getShortName());
        $name = preg_replace('/(?=[A-Z])(?!\A)/', '_', $name);

        return strtolower($name);
    }

    public function isBadConfigured()
    {
        return
            empty($this->commandName) ||
            empty($this->commandAction) ||
            $this->parallelProcessAmount <= 0;
    }

    public function getLogFileName($number)
    {
        return str_replace([' ', '/', '\\'], '_', implode('_', [
            $this->commandName,
            $this->commandAction,
            $this->getArguments(),
            $number
        ]));
    }

    public function getCommandText()
    {
        return $this->commandName. '/' . $this->commandAction . ' ' . $this->getArguments();
    }

    public function countWaiting()
    {
        return Bernard::countQueue($this->queueName());
    }
}