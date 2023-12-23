<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Product */
/* @var $form app\components\mgcms\yii\ActiveForm */
yii\jui\JuiAsset::register($this);
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $this->render('/common/languageBehaviorSwicher', ['model' => $model, 'form' => $form]) ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field6md($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field6md($model, 'category_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Category::find()->andWhere(['type' => \app\models\mgcms\db\Category::TYPE_PRODUCT_TYPE])->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Category'), 'prompt' => '',],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field12md($model, 'description')->tinyMce(['rows' => 6]) ?>

    <?= $form->field12md($model, 'specification')->tinyMce(['rows' => 6]) ?>

    <?= $form->field4md($model, 'price')->textInput(['placeholder' => 'Price']) ?>

    <?= $form->field4md($model, 'number')->textInput(['placeholder' => 'Number']) ?>

    <?= $form->field4md($model, 'is_special_offer')->switchInput() ?>

    <?= $form->field6md($model, 'special_offer_from')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Special Offer From'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field4md($model, 'special_offer_to')->widget(\kartik\datecontrol\DateControl::classname(), [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Choose Special Offer To'),
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field4md($model, 'min_amount_of_purchase')->textInput(['placeholder' => 'Min Amount Of Purchase']) ?>

    <?= $form->field4md($model, 'special_offer_price')->textInput(['placeholder' => 'Special Offer Price']) ?>


    <?= $form->field4md($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->where(['created_by' => MgHelpers::getUserModel()->id])->orderBy('id')->asArray()->all(), 'id', 'origin_name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose File'), 'prompt' => '',],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $this->render('../common/_imagesForm', ['model' => $model, 'form' => $form]) ?>

    <?= $this->render('../common/_downloadFilesForm', ['model' => $model, 'form' => $form]) ?>



    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?php endif; ?>
                <?php if (Yii::$app->controller->action->id != 'create'): ?>
                    <?= Html::submitButton(Yii::t('app', 'Save As New'), ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
                <?php endif; ?>
                <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
