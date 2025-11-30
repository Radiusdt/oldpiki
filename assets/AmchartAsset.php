<?php
namespace app\assets;

use yii\web\AssetBundle;

class AmchartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
    ];

    public $js = [
        'https://cdn.amcharts.com/lib/4/core.js',
        'https://cdn.amcharts.com/lib/4/charts.js',
        'https://cdn.amcharts.com/lib/4/themes/frozen.js',
        'https://cdn.amcharts.com/lib/4/themes/animated.js'
    ];

    public $depends = [
        'app\assets\AppAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}