<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Ad;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Ad */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= MgHelpers::isAdmin() ? $form->field($model, 'status')->dropDownList(Ad::STATUSES) : '' ?>

    <?= $form->field($model, 'date_to')->dateTimePicker() ?>

    <?= $form->field($model, 'country')->dropDownList(MgHelpers::getAllCountriesArray()) ?>

    <?= $form->field($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose File')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
