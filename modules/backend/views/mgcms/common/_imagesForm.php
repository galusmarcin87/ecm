<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Product */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="col-md-12">
    <div class="well">
        <div class="col-md-12">
            <?= $form->relatedFileInput($model, true, true) ?>
        </div>

        <legend><?= Yii::t('app', 'Images'); ?></legend>
        <? /*---------------specyfic for this project distinguish between files ------------------*/ ?>
        <div class="row images itemsFlex">
            <? foreach ($model->fileRelations as $relation): ?>

                <? if ($relation->json != '' || !$relation->file) continue ?>
                <div class="col-md-3 center bottom10">
                    <?= \kartik\helpers\Html::hiddenInput("fileOrder[" . $relation->file->id . "]") ?>
                    <? echo \yii\helpers\Html::a(Icon::show('trash', ['class' => 'gi-2x']), MgHelpers::createUrl(['backend/mgcms/file/delete-relation', 'relId' => $model->id, 'fileId' => $relation->file->id, 'model' => $model::className()]), ['onclick' => 'return confirm("' . Yii::t('app', 'Are you sure?') . '")', 'class' => 'deleteLink']) ?>
                    <?= $relation->file->getThumb(250, 250, true, \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET, ['class' => 'img-responsive']) ?>
                    <? \kartik\helpers\Html::textarea("FileRelation[$relation->file->id][$model->id][" . $model::className() . "][description]", 'aaa', ['class' => 'form-control']) ?>
                </div>
            <? endforeach ?>
        </div>

        <script type="text/javascript">
          $(document).ready(function () {
            $('.images').sortable();
          });

        </script>
    </div>
</div>
