<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\ProjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-project-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->textInput(['placeholder' => 'Id']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true, 'placeholder' => 'Status']) ?>

    <?= $form->field($model, 'localization')->textInput(['maxlength' => true, 'placeholder' => 'Localization']) ?>

    <?= $form->field($model, 'gps_lat')->textInput(['maxlength' => true, 'placeholder' => 'Gps Lat']) ?>

    <?php /* echo $form->field($model, 'gps_long')->textInput(['maxlength' => true, 'placeholder' => 'Gps Long']) */ ?>

    <?php /* echo $form->field($model, 'lead')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'text')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose File')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'whitepaper')->textInput(['maxlength' => true, 'placeholder' => 'Whitepaper']) */ ?>

    <?php /* echo $form->field($model, 'www')->textInput(['maxlength' => true, 'placeholder' => 'Www']) */ ?>

    <?php /* echo $form->field($model, 'money')->textInput(['placeholder' => 'Money']) */ ?>

    <?php /* echo $form->field($model, 'money_full')->textInput(['placeholder' => 'Money Full']) */ ?>

    <?php /* echo $form->field($model, 'investition_time')->textInput(['maxlength' => true, 'placeholder' => 'Investition Time']) */ ?>

    <?php /* echo $form->field($model, 'percentage')->textInput(['placeholder' => 'Percentage']) */ ?>

    <?php /* echo $form->field($model, 'date_presale_start')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Date Presale Start'),
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'date_presale_end')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Date Presale End'),
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'date_crowdsale_start')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Date Crowdsale Start'),
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'date_crowdsale_end')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Date Crowdsale End'),
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'percentage_presale_bonus')->textInput(['placeholder' => 'Percentage Presale Bonus']) */ ?>

    <?php /* echo $form->field($model, 'date_realization_profit')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Date Realization Profit'),
                'autoclose' => true
            ]
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'token_value')->textInput(['placeholder' => 'Token Value']) */ ?>

    <?php /* echo $form->field($model, 'token_blockchain')->textInput(['maxlength' => true, 'placeholder' => 'Token Blockchain']) */ ?>

    <?php /* echo $form->field($model, 'token_to_sale')->textInput(['placeholder' => 'Token To Sale']) */ ?>

    <?php /* echo $form->field($model, 'token_minimal_buy')->textInput(['placeholder' => 'Token Minimal Buy']) */ ?>

    <?php /* echo $form->field($model, 'token_left')->textInput(['placeholder' => 'Token Left']) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
