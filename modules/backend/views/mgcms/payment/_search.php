<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\PaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field12md($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field12md($model, 'created_on')->textInput(['placeholder' => $model->getAttributeLabel('created_on')]) ?>

    <?= $form->field($model, 'project_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Project::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Project')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'user_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\User::find()->orderBy('id')->asArray()->all(), 'id', 'username'),
        'options' => ['placeholder' => Yii::t('app', 'Choose User')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field12md($model, 'amount')->textInput(['placeholder' => $model->getAttributeLabel('amount')]) ?>

    <?php /* echo $form->field12md($model, 'status')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('status')]) */ ?>

    <?php /* echo $form->field12md($model, 'percentage')->textInput(['placeholder' => $model->getAttributeLabel('percentage')]) */ ?>

    <?php /* echo $form->field12md($model, 'is_preico')->checkbox() */ ?>

    <?php /* echo $form->field12md($model, 'user_token')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('user_token')]) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
