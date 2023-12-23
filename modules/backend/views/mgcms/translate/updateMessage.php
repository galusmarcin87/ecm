<?php
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\I18nSourceMessage */

$this->title = Yii::t('app', 'Update translation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Translations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>

<div class="i18n-source-message-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->errorSummary($model); ?>

  <?= Html::textarea('translation', $model->sourceMessage->message, array('rows' => 6, 'cols' => 50, 'class' => 'form-control', 'disabled' => true)) ?>

  <?= $form->field($model, 'translation')->textarea(['rows' => 6]) ?>

  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
