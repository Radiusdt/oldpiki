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
class OuterAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/template/mazer/assets/compiled/css/app.css',
        '/template/mazer/assets/compiled/css/app-dark.css',
        '/template/mazer/assets/compiled/css/auth.css',
        '/css/style.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/gh/zuramai/mazer@docs/demo/assets/static/js/initTheme.js',
        '/template/plugins/sweet-alert2/sweetalert2.min.js',
        '/template/js/custom.js',
        '/js/custom.js',
        '/js/copy.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
