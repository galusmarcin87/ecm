<?php
use \yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $model app\models\mgcms\db\Gallery */

?>

<a class="col-md-3 col-sm-6 galleryLink bottom10" href="<?= $model->linkUrl ?>">
  <div class="wrapper">
    <span class="gradient"></span>
    <? if ($model->file): ?>
      <?=
      $model->file->getImage(262, 262, ['class' => 'width100'], \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)
      ?>
    <? else: ?>
      <span class="imagePlug"></span>
    <? endif ?>
    <h2><?= $model->name ?></h2>
  </div>

</a>

