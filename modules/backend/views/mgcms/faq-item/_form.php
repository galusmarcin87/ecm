<?php
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\FaqItem */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="faq-item-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->errorSummary($model); ?>

  <div class="row">
    <?= $form->field12md($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field12md($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field12md($model, 'answer')->textarea(['rows' => 6]) ?>

    <?=
    $form->field12md($model, 'faq_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Faq::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Faq')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>

    <?= $form->field12md($model, 'order')->textInput(['placeholder' => $model->getAttributeLabel('order')]) ?>

<?= $form->field12md($model, 'content')->tinyMce(['rows' => 6]) ?>

  </div>
  <div class="form-group">
    <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
      <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if (Yii::$app->controller->action->id != 'create'): ?>
      <?= Html::submitButton(Yii::t('app', 'Save As New'), ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
<?php endif; ?>
  <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
  </div>

<?php ActiveForm::end(); ?>

</div>
