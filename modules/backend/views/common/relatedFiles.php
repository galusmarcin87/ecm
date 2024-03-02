<?
/* @var $model app\models\mgcms\db\AbstractRecord */

?>
<? if ($model->files): ?>
  <? foreach ($model->files as $file): ?>
    <? if ($file->isImage()): ?>
      <?= $file->getThumb(250, 250, true, \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET, ['class' => 'img-responsive']) ?>
    <? else: ?>
      <a href="<?= $file->getWebPath() ?>"><?= (string) $file ?></a>
    <? endif ?>
    <? endforeach ?>
  <?
 endif ?>