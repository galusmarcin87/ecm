<?php
/* @var $model app\models\mgcms\db\Gallery */
use mgcms\lightbox\Lightbox;
use \app\models\mgcms\db\FileRelation;

Lightbox::widget();
use \yii\helpers\Html;

?>

<h1><?= $model->name ?></h1>

<div class="galleryDescription">
  <?= $model->description ?>
</div>

<div class="gallerySlides row itemsFlex">
  <? foreach ($model->files as $file): ?>
    <div class="col-md-3 center bottom10 centerAll">
      <?
      $description = FileRelation::getJsonAttribute($file->id, $model->id, $model::className(), 'description');
      ?>
      <?=
      Html::a($file->getImage(262, 262, ['class' => 'img-responsive'], \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND), $file->getWebPath(), ['data-lightbox' => 'lightbox', 'target' => '_blank', 'title' => $description])

      ?>
    </div>
<? endforeach ?>
</div>

