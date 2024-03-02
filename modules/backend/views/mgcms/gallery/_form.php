<?php
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use app\components\mgcms\yii\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Gallery */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="gallery-form">

  <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

  <?= $form->errorSummary($model); ?>

  <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

  <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('name')]) ?>

  <?= $form->field($model, 'description')->tinyMce() ?>

  <div class="row">
    <div class="col-md-3">
      <?=
      $form->field($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
          'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('id')->asArray()->all(), 'id', 'origin_name'),
          'options' => ['placeholder' => Yii::t('app', 'Choose File')],
          'pluginOptions' => [
              'allowClear' => true
          ],
      ]);

      ?>
    </div>
    <div class="col-md-3">
      <?= $form->relatedFileInput($model, true, true) ?>
    </div>
    <div class="col-md-3">
      <?=
      $form->field($model, 'promoted')->switchInput();

      ?>
    </div>
    <div class="col-md-3">
      <?= $form->field($model, 'order')->textInput(['placeholder' => $model->getAttributeLabel('order')]) ?>
    </div>
  </div>

  
  <div class="well">
    <?= $this->render('_images', ['model' => $model, 'editable' => true]) ?>
  </div>
  


  <div class="form-group">
    <?=
    Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])

    ?>
    <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>


