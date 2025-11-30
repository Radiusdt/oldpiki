<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class SweetAlertAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/template/plugins/sweet-alert2/sweetalert2.min.css',
    ];
    public $js = [
        '/template/plugins/sweet-alert2/sweetalert2.min.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
