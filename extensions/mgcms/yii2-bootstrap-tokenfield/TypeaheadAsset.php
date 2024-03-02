<?php

namespace mgcms\tokenfield;

use yii\web\AssetBundle;
use Yii;

class TypeaheadAsset extends AssetBundle {

    public $sourcePath = '';

	public $css = [

    ];

	public $js = [
		'typeahead.bundle.min.js',
	];

    public $depends = [
        'yii\web\JqueryAsset'
    ];

	/**
     * @inheritdoc
     */
    public function init() {
        $this->sourcePath = "@vendor/bower/typeahead.js/dist";
        parent::init();
    }
}
