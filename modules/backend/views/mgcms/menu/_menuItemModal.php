<?
use yii\bootstrap\Modal;
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

?>

<?
Modal::begin([
    'header' => '<h2>'.Yii::t('app', 'Edit menu item').'</h2>',
    'id' => 'edit' . $model->id,
]);

?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->errorSummary($model); ?>

<?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

<?= $form->field($model, 'url')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('url')]) ?>

<?= $form->field($model, 'label')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('label')]) ?>

<div class="form-group">
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php
ActiveForm::end();
Modal::end();

?>