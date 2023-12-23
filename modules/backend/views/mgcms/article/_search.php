<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\ArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-article-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('title')]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('slug')]) ?>

    <?= $form->field($model, 'excerpt')->textarea(['rows' => 6]) ?>

    <?php /* echo $form->field($model, 'language')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('language')]) */ ?>

    <?php /* echo $form->field($model, 'created_on')->textInput(['placeholder' => $model->getAttributeLabel('created_on')]) */ ?>

    <?php /* echo $form->field($model, 'updated_on')->textInput(['placeholder' => $model->getAttributeLabel('updated_on')]) */ ?>

    <?php /* echo $form->field($model, 'meta_title')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('meta_title')]) */ ?>

    <?php /* echo $form->field($model, 'meta_description')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('meta_description')]) */ ?>

    <?php /* echo $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('meta_keywords')]) */ ?>

    <?php /* echo $form->field($model, 'status')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('status')]) */ ?>

    <?php /* echo $form->field($model, 'parent_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Article::find()->orderBy('id')->asArray()->all(), 'id', 'title'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Article')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'category_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Category::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Category')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose File')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <?php /* echo $form->field($model, 'order')->textInput(['placeholder' => $model->getAttributeLabel('order')]) */ ?>

    <?php /* echo $form->field($model, 'promoted')->checkbox() */ ?>

    <?php /* echo $form->field($model, 'custom')->textarea(['rows' => 6]) */ ?>

    <?php /* echo $form->field($model, 'type')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('type')]) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
