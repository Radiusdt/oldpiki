<?php

namespace app\components;

use yii\helpers\VarDumper;
use yii\log\FileTarget;
use yii\log\Logger;

class LogFileTarget extends FileTarget
{
    public $traceLevel = 0;

    public function formatMessage($message)
    {
        list($text, $level, $category, $timestamp) = $message;
        $level = Logger::getLevelName($level);
        if (!is_string($text)) {
            if ($text instanceof \Exception) {
                $text = (string)$text;
            } else {
                $text = VarDumper::export($text);
            }
        }

        $traces = [];
        if (isset($message[4]) && $this->traceLevel > 0) {
            $count = 0;
            foreach ($message[4] as $trace) {
                $traces[] = "in {$trace['file']}:{$trace['line']}";
                if (++$count >= $this->traceLevel) {
                    break;
                }
            }
        }

        $prefix = $this->getMessagePrefix($message);
        return date('Y-m-d H:i:s', $timestamp) . " {$prefix}[$level][$category] $text"
            . (empty($traces) ? '' : "\n    " . implode("\n    ", $traces));
    }
}
