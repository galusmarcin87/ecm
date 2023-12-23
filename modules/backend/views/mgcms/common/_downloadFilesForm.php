<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Product */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="col-md-12 ">
    <div class="well row ">
        <div class="col-md-12">
            <?= $form->field($model, 'downloadFiles[]')->fileInput(['multiple' => true, 'accept' => 'application/pdf',]) ?>
            <legend><?= Yii::t('app', 'Files to download'); ?></legend>
            <? foreach ($model->fileRelations as $relation): ?>
                <? if ($relation->json != '1' || !$relation->file) continue ?>
                <div class="col-md-3 center bottom10">
                    <? echo \yii\helpers\Html::a(Icon::show('trash', ['class' => 'gi-2x']), MgHelpers::createUrl(['backend/mgcms/file/delete-relation', 'relId' => $model->id, 'fileId' => $relation->file->id, 'model' => $model::className()]), ['onclick' => 'return confirm("' . Yii::t('app', 'Are you sure?') . '")', 'class' => 'deleteLink']) ?>
                    <?= Html::a($relation->file->origin_name, $relation->file->linkUrl) ?>

                </div>
            <? endforeach ?>
        </div>
    </div>
</div>
