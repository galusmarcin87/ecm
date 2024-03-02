<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\User */
/* @var $form app\components\mgcms\yii\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'User',
        'relID' => 'user',
        'value' => \yii\helpers\Json::encode($model->users),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $this->render('/common/languageBehaviorSwicher', ['model' => $model, 'form' => $form]) ?>

    <div class="row">
		<?= $form->field4md($model, 'username')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('username')]) ?>
		
		<?= $form->field4md($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')]) ?>
		
		<?= $form->field4md($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('first_name')]) ?>
		
		<?= $form->field4md($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('last_name')]) ?>
		
		<?= $form->field4md($model, 'role')->dropDownList(MgHelpers::arrayKeyValueFromArray(MgHelpers::getUserModel()->getRolesManagableForUser(), true), ['maxlength' => true]) ?>
		
		<?= $form->field4md($model, 'status')->dropDownList(MgHelpers::arrayTranslateValues(\app\models\mgcms\db\User::STATUSES), ['maxlength' => true]) ?>
		
		<?= $form->field4md($model, 'birthdate')->datePicker(); ?>
		
		<?= $form->field4md($model, 'street')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('street')]) ?>
		
		<?= $form->field4md($model, 'flat_no')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('flat_no')]) ?>
		
		<?= $form->field4md($model, 'house_no')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('house_no')]) ?>
		
		<?= $form->field4md($model, 'postcode')->textInput(['maxlength' => true, 'placeholder2' => 'City']) ?>
		
		<?= $form->field4md($model, 'city')->textInput(['maxlength' => true, 'placeholder2' => 'City']) ?>
		
		<?= $form->field4md($model, 'voivodeship')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('voivodeship')]) ?>
		
		<?= $form->field4md($model, 'pesel')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('pesel')]) ?>
		
		<?= $form->field4md($model, 'id_document_no')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('id_document_no')]) ?>
		
		<?= $form->field4md($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('phone')]) ?>


        <div class="col-md-4">
            <?= $this->render('/common/_fileModalChooser', [
                'model' => $model,
                'form' => $form]) ?>
        </div>


        <?= $form->field12md($model, 'testResult')->tinyMce([],['rows' => 60]) ?>

    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


