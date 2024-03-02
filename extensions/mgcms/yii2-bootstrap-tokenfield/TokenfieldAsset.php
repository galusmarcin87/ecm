<?php

namespace mgcms\tokenfield;

use yii\web\AssetBundle;
use Yii;

class TokenfieldAsset extends AssetBundle {

    public $sourcePath = '';

	public $css = [
        'css/bootstrap-tokenfield.min.css',
    ];

	public $js = [
        'bootstrap-tokenfield.min.js',
	];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

	/**
     * @inheritdoc
     */
    public function init() {
        $this->sourcePath = "@vendor/npm-asset/bootstrap-tokenfield/dist";
        parent::init();
    }
}

