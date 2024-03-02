<?php
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\TeamMember */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="team-member-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->errorSummary($model); ?>

  <div class="row">
    <?= $form->field12md($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $this->render('/common/languageBehaviorSwicher', ['model' => $model, 'form' => $form]) ?>

    <?= $form->field6md($model, 'name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('name')]) ?>

    <?= $form->field6md($model, 'surname')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('surname')]) ?>

    <?= $form->field6md($model, 'is_team')->switchInput() ?>

    <?= $form->field6md($model, 'is_consultant')->switchInput() ?>

    <?= $form->field12md($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('phone')]) ?>

    <?= $form->field12md($model, 'description')->textarea() ?>

    <?=
    $form->field6md($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('id')->asArray()->all(), 'id', 'origin_name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose File')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>
  </div>
  <div class="form-group">
    <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
      <?=
      Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])

      ?>
    <?php endif; ?>
    <?php if (Yii::$app->controller->action->id != 'create'): ?>
      <?= Html::submitButton(Yii::t('app', 'Save As New'), ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
    <?php endif; ?>
    <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>
