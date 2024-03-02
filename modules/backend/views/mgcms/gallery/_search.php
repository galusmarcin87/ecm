<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\GallerySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-gallery-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('name')]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('slug')]) ?>

    <?= $form->field($model, 'created_on')->textInput(['placeholder' => $model->getAttributeLabel('created_on')]) ?>

    <?= $form->field($model, 'order')->textInput(['placeholder' => $model->getAttributeLabel('order')]) ?>

    <?php /* echo $form->field($model, 'description')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'promoted')->checkbox() */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
