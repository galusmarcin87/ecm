<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Article;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Article */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>
	
	   <div class="row">
	  <div class="col-md-3"> 
		  <?= $form->field($model, 'language')->dropDownList(array_combine(MgHelpers::getConfigParam('languages'), MgHelpers::getConfigParam('languages'))) ?>
		  </div>
	   <div class="col-md-3"> 
		  <?= $form->field($model, 'status')->dropDownList(MgHelpers::translatedSBValueFromArray(Article::STATUSES)) ?>
		   </div>
	   <div class="col-md-3"> 
		  <?= $form->field($model, 'type')->dropDownList(app\components\mgcms\MgHelpers::arrayKeyValueFromArray(\app\models\mgcms\db\Article::TYPES, true), ['maxlength' => true, 'placeholder' => 'Type', 'prompt' => '']) ?>
		   </div>
	   <div class="col-md-3">
            <?= $form->field($model, 'order')->textInput(['placeholder' => $model->getAttributeLabel('order')]) ?>
        </div>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('title')]) ?>

    <?= $form->field($model, 'content')->tinyMce(['height' => 480]) ?>

    <?= $form->field($model, 'excerpt')->tinyMce() ?>



    <div class="row">
        <div class="col-md-3">
            <?= $this->render('/common/_fileModalChooser', [
                'model' => $model,
                'form' => $form]) ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->relatedFileInput($model, true, true) ?>
        </div>
    </div>


    <div class="well">
        <legend><?= Yii::t('app', 'Images'); ?></legend>
        <?= $this->render('/common/_images', ['model' => $model, 'editable' => true]) ?>
    </div>
	
	
	<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('meta_title')]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('meta_description')]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('meta_keywords')]) ?>

    <?= $form->field($model, 'tagString')->widget(\mgcms\tokenfield\Tokenfield::className(), [
        'pluginOptions' => [
            'delimiter' => ',', // default ',' (comma)
            'showAutocompleteOnFocus' => true,
            'autocomplete' => [
                'source' => \app\models\mgcms\db\Tag::getTagsNamesArray(),
                'delay' => 100,
            ],
        ],
    ]); ?>

    <div class="form-group">
        <?=
        Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])

        ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
