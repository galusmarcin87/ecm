<?php

namespace mgcms\lightbox;

use yii\web\AssetBundle;

class LightboxAsset extends AssetBundle {

    public $sourcePath = '@bower/lightbox2/src';

    public $js = [
        'js/lightbox.js',
    ];

    public $css = [
        'css/lightbox.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

