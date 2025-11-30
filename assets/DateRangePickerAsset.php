<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class DateRangePickerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/template/plugins/bootstrap-daterangepicker/daterangepicker.css',
    ];
    public $js = [
        '/template/plugins/moment/moment.min.js',
        '/template/plugins/bootstrap-daterangepicker/daterangepicker.js',
        '/template/plugins/bootstrap-daterangepicker/init.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
