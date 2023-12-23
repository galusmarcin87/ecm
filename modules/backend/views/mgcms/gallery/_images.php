<?
use kartik\icons\Icon;
use app\components\mgcms\MgHelpers;
use \app\models\mgcms\db\FileRelation;

$editable = isset($editable) ? $editable : false;
if ($editable){
  yii\jui\JuiAsset::register($this);
}

/* @var $model app\models\mgcms\db\Gallery */



?>
<div class="row images itemsFlex">
  <? foreach ($model->files as $file): ?>
    <div class="col-md-3 center bottom10">
      <?
        $description = FileRelation::getJsonAttribute($file->id, $model->id, $model::className(), 'description');
        $file->lightBoxTitle = $description;
      ?>
      <?= \kartik\helpers\Html::hiddenInput("fileOrder[$file->id]") ?>
      <?  if ($editable)  echo \yii\helpers\Html::a(Icon::show('trash', ['class' => 'gi-2x']), MgHelpers::createUrl(['backend/mgcms/file/delete-relation', 'relId' => $model->id, 'fileId' => $file->id, 'model' => $model::className()]), ['onclick' => 'return confirm("' . Yii::t('app', 'Are you sure?') . '")', 'class' => 'deleteLink'])        ?>
      <?= $file->getThumb(250, 250, true, \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET, ['class' => 'img-responsive']) ?>
      
      <? if ($editable):?>
        <?= \kartik\helpers\Html::textarea("FileRelation[$file->id][$model->id][" . $model::className() . "][description]", $description, ['class' => 'form-control']) ?>
      <?else:?>
        <label><?=$description?>&nbsp;</label>
      <?endif?>
      
    </div>
  <? endforeach ?>
</div>

<? if ($editable): ?>
  <script type="text/javascript">
    $(document).ready(function () {
      $(".images").sortable();
    });

  </script>
  <?endif?>