<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Job */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="job-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $this->render('/common/languageBehaviorSwicher', ['model' => $model, 'form' => $form]) ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field6md($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field4md($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->where(['created_by' => MgHelpers::getUserModel()->id])->orderBy('id')->asArray()->all(), 'id', 'origin_name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose File'), 'prompt' => '',],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>


    <?= $form->field6md($model, 'salary')->textInput(['placeholder' => 'Salary']) ?>

    <?= $form->field6md($model, 'position')->textInput(['maxlength' => true, 'placeholder' => 'Position']) ?>

    <?= $form->field6md($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address']) ?>

    <?= $form->field4md($model, 'industry')->dropDownList(MgHelpers::getSettingOptionArrayTranslated('industries array'), ['prompt' => '']) ?>

    <?= $form->field4md($model, 'country')->dropDownList(MgHelpers::getSettingOptionArrayTranslated('countries array'), ['prompt' => '']) ?>

    <?= $form->field4md($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'City']) ?>

    <?= $form->field12md($model, 'info')->tinyMce() ?>

    <?= $form->field12md($model, 'requirements')->tinyMce() ?>



    <div class="form-group col-md-12">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
