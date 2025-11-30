<?php

namespace app\components;

use yii\base\Component;

class Format extends Component
{
    public function init()
    {
        parent::init();
    }


    public function plural($num, $form1, $form2, $form5, $addNum = false)
    {
        $n = abs($num) % 100;
        $n1 = $n % 10;
        if ($n > 10 && $n < 20) {
            return (empty($addNum) ? '' : $num . ' ') . $form5;
        } elseif ($n1 > 1 && $n1 < 5) {
            return (empty($addNum) ? '' : $num . ' ') . $form2;
        } elseif ($n1 == 1) {
            return (empty($addNum) ? '' : $num . ' ') . $form1;
        }
        return (empty($addNum) ? '' : $num . ' ') . $form5;
    }

    public function time($time, $showSeconds = true)
    {
        if (empty($time)) {
            return 'Не указано';
        }
        if (empty($showSeconds)) {
            $format = 'HH:mm';
        } else {
            $format = 'HH:mm:ss';
        }

        return \Yii::$app->formatter->asTime($time, $format);
    }

    public function numberShorten($number, $precision = 3, $divisors = null)
    {
        if (!isset($divisors)) {
            $divisors = [
                pow(1000, 0) => '', // 1000^0 == 1
                pow(1000, 1) => 'K', // Thousand
                pow(1000, 2) => 'M', // Million
                pow(1000, 3) => 'B', // Billion
                pow(1000, 4) => 'T', // Trillion
                pow(1000, 5) => 'Qa', // Quadrillion
                pow(1000, 6) => 'Qi', // Quintillion
            ];
        }

        foreach ($divisors as $divisor => $shorthand) {
            if (abs($number) < ($divisor * 1000)) {
                break;
            }
        }
        if ($divisor <= 1) {
            return $number;
        }

        return number_format($number / $divisor, $precision) . $shorthand;
    }


    public function downloadsShorten($number, $isShort = true)
    {
        $amounts = [
            50,
            100,
            500,
            1000,
            5000,
            10000,
            50000,
            100000,
            500000,
            1000000,
            5000000,
            10000000,
            50000000,
            100000000,
            500000000,
            1000000000,
            5000000000,
        ];

        $lastStep = 0;
        foreach ($amounts as $shorthand) {
            if (abs($number) < $shorthand) {
                return $isShort ? ($this->numberShorten($lastStep, 0) . '+') : $lastStep;
            }
            $lastStep = $shorthand;
        }

        return 0;
    }
}