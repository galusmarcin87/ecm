<?php
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\File */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="file-form">

  <?php $form = ActiveForm::beginFileForm(); ?>

  <?= $form->errorSummary($model); ?>

  <?= $form->field($model, 'name[]')->fileInputPretty(['multiple' => true]) ?>

  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
