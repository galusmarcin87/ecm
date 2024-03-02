<?php

use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form app\components\mgcms\yii\ActiveForm */
/* @var $model \app\models\mgcms\db\AbstractRecord */


?>



<?= $form->field($model, 'file_id')->hiddenInput(); ?>

<?
Modal::begin([
    'header' => '<h2>' . Yii::t('app', 'Choose file') . '</h2>',
    'toggleButton' => [
        'label' => Yii::t('app', 'Choose file'),
        'class' => 'btn btn-primary',
        'style' => ['margin-top' => '-20px']
    ],
    'size' => Modal::SIZE_LARGE,
    'options' => ['id' => 'fileModal']
]);

?>
<iframe src="<?= Url::to(['mgcms/file/choose-file']) ?>" style="width:100%; height: 500px;"
        frameborder="0"></iframe>
<?
Modal::end();

?>
<div id="imageFileWrapper" class="width100">
    <? if ($model->file): ?>
        <? if ($model->file->isImage()): ?>
            <?= $model->file->thumb ?>
        <? else: ?>
            <a class="top10" href="<?= $model->file->webPath ?>"><?= $model->file ?></a>
        <? endif ?>
        <a href="<?= Url::to(['remove-image', 'id' => $model->id]) ?>"><?= \kartik\icons\Icon::show('trash') ?></a>
    <? endif ?>

</div>


<script type="text/javascript">
  function chooseFile (fileId, fileSrc, isImage) {
    $("input[id*=file_id]").val(fileId)
    $('#imageFileWrapper').
      html(isImage ? '<img src="' + fileSrc + '"/>' : '<a href="' + fileSrc + '">' + fileSrc + '</a>')
    $('#fileModal').modal('toggle')
  }
</script>
