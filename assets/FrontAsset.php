<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrontAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'less/front.less',
    ];
    public $js = [
        '/js/vendor/bootstrap.bundle.min.js',
        '/js/vendor/jquery.appear.js',
        '/js/vendor/TweenLite.min.js',
        'https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyD9AbR7v9VcflkE06B3qdNXiU7ErvoUYP8',
        '/js/vendor/infobox_packed.js',
        '/js/vendor/countdown.js',
        '/js/vendor/swiper-bundle.min.js',
        '/js/app.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset'
//        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}
