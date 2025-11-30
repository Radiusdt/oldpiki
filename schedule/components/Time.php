<?php
namespace app\schedule\components;

class Time
{
    public $minute = '*';
    public $hour = '*';
    public $dayOfMonth = '*';
    public $month = '*';
    public $dayOfWeek = '*';

    public function __construct($minute = '*', $hour = '*', $dayOfMonth = '*', $month = '*', $dayOfWeek = '*')
    {
        $this->minute = $minute;
        $this->hour = $hour;
        $this->dayOfMonth = $dayOfMonth;
        $this->month = $month;
        $this->dayOfWeek = $dayOfWeek;
    }

}