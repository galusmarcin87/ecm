<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('username')]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('first_name')]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('last_name')]) ?>

    <?php /* echo $form->field($model, 'role')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('role')]) */ ?>

    <?php /* echo $form->field($model, 'status')->textInput(['placeholder' => $model->getAttributeLabel('status')]) */ ?>

    <?php /* echo $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('email')]) */ ?>

    <?php /* echo $form->field($model, 'created_on')->textInput(['placeholder' => $model->getAttributeLabel('created_on')]) */ ?>

    <?php /* echo $form->field($model, 'last_login')->textInput(['placeholder' => $model->getAttributeLabel('last_login')]) */ ?>

    <?php /* echo $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('address')]) */ ?>

    <?php /* echo $form->field($model, 'postcode')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('postcode')]) */ ?>

    <?php /* echo $form->field($model, 'birthdate')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app',Yii::t('app', 'Choose Birthdate')),
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('city')]) */ ?>

    <?php /* echo $form->field($model, 'auth_key')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('auth_key')]) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
