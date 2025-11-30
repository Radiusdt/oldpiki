<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DarkAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/template/mazer/assets/compiled/css/app-dark.css',
    ];
    public $js = [
        '/template/mazer/assets/static/js/components/dark.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
}
