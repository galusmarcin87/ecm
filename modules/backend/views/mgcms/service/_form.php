<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Service */
/* @var $form app\components\mgcms\yii\ActiveForm */
yii\jui\JuiAsset::register($this);
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $this->render('/common/languageBehaviorSwicher', ['model' => $model, 'form' => $form]) ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field6md($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field6md($model, 'price')->textInput(['placeholder' => 'Price']) ?>

    <?= $form->field12md($model, 'description')->tinyMce(['rows' => 6]) ?>

    <?= $form->field12md($model, 'specification')->tinyMce(['rows' => 6]) ?>

    <?= $this->render('../common/_imagesForm', ['model' => $model, 'form' => $form]) ?>

    <?= $this->render('../common/_downloadFilesForm', ['model' => $model, 'form' => $form]) ?>

    <div class="form-group">
        <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
