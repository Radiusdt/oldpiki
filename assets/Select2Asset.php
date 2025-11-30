<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/template/plugins/select2/select2.min.css',
    ];
    public $js = [
        '/template/plugins/select2/select2.full.min.js',
        '/template/plugins/select2/init.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
