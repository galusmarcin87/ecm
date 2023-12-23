<?php
/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Article */
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

?>

<section class="text-box blog">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <?= $model->content ?>
      </div>
    </div>
  </div>
</section>