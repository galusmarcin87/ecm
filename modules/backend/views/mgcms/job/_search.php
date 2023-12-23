<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\JobSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-job-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'company_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Company::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Company')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'salary')->textInput(['placeholder' => 'Salary']) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true, 'placeholder' => 'Position']) ?>

    <?php /* echo $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address']) */ ?>

    <?php /* echo $form->field($model, 'industry')->textInput(['maxlength' => true, 'placeholder' => 'Industry']) */ ?>

    <?php /* echo $form->field($model, 'info')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'requirements')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'country')->textInput(['maxlength' => true, 'placeholder' => 'Country']) */ ?>

    <?php /* echo $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'City']) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
