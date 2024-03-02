<?php
namespace app\modules\backend\assets;

use yii\web\AssetBundle;


class BackendAssets extends AssetBundle
{

  public $sourcePath = '@app/modules/backend/assets';

  public $css = [
      'css/bootstrap.min.css',
      'less/backend.less',
      'css/backend.css',
  ];
  public $js = [
      'js/backend.js'
  ];
  public $depends = [
      'yii\web\YiiAsset',
      'yii\bootstrap\BootstrapAsset',
  ];

}
