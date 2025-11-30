<?php
namespace app\schedule\components;

use yii\base\Component;

/**
 * @property string $command
 */
abstract class Cron extends Component
{
    public $commandName = 'queue';
    public $commandAction = 'process';

    public $description;

    /**
     * @return Time[]
     */
    abstract function time();

    public function getCommand()
    {
        $yiicPath = '/usr/local/bin/php ' . \Yii::getAlias('@app/yii');

        if (empty($this->commandAction)) {
            return $this->commandName;
        }
        return $yiicPath . ' ' . $this->commandName . '/' . $this->commandAction;
    }

    public function isBadConfigured()
    {
        return empty($this->commandName);
    }
}