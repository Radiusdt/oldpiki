<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/template/mazer/assets/compiled/css/app.css',
        '/css/style.css',
    ];
    public $js = [
        '/template/mazer/assets/static/js/initTheme.js',
        //'/template/mazer/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js',
        '/template/mazer/assets/js/app.js',
        //'/template/mazer/assets/js/bootstrap.bundle.min.js',
        //'/template/mazer/assets/extensions/parsleyjs/parsley.min.js',
        //'/template/mazer/assets/static/js/pages/parsley.js',
        '/template/plugins/sweet-alert2/sweetalert2.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js',
        //'/template/js/custom.js',
        '/js/custom.js',
        '/js/copy.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\DateRangePickerAsset',
        'app\assets\Select2Asset',
        'app\assets\SweetAlertAsset',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
