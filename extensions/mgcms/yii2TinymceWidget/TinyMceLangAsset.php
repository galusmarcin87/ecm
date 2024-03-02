<?php

namespace app\extensions\mgcms\yii2TinymceWidget;

use yii\web\AssetBundle;

class TinyMceLangAsset extends AssetBundle
{
    public $sourcePath = '@app/extensions/mgcms/yii2TinymceWidget/assets/';

    public $depends = [
        'app\extensions\mgcms\yii2TinymceWidget\TinyMceAsset'
    ];
}
