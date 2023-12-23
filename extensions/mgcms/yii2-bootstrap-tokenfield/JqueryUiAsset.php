<?php

namespace mgcms\tokenfield;

use yii\web\AssetBundle;
use Yii;

class JqueryUiAsset extends AssetBundle {

    public $sourcePath = '@app/extensions/mgcms/yii2-bootstrap-tokenfield';

	public $css = [
        'jquery-ui-1.12.1.css',
    ];

	public $js = [
        'jquery-ui-1.12.1.js',

	];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

	/**
     * @inheritdoc
     */
    public function init() {
        parent::init();
    }
}
