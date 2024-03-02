<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Agent */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="agent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $this->render('/common/languageBehaviorSwicher', ['model' => $model, 'form' => $form]) ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field6md($model, 'full_name')->textInput(['maxlength' => true, 'placeholder2' => 'Full Name']) ?>

        <?= $form->field6md($model, 'position')->textInput(['maxlength' => true, 'placeholder2' => 'Position']) ?>

    <?= $form->field12md($model, 'description')->tinyMce(['rows' => 6]) ?>

    <?= $form->field4md($model, 'phone')->textInput(['maxlength' => true, 'placeholder2' => 'Phone']) ?>

    <?= $form->field4md($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('id')->asArray()->all(), 'id', 'origin_name'),
        'options' => ['placeholder2' => Yii::t('app', 'Choose File'), ['prompt' => '']],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field4md($model, 'email')->textInput(['maxlength' => true, 'type' => 'Eeail']) ?>


    <div class="form-group col-md-12">
    <?php if(Yii::$app->controller->action->id != 'save-as-new'): ?>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
