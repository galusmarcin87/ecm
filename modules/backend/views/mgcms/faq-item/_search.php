<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\FaqItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-faq-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field12md($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field12md($model, 'question')->textarea(['rows' => 6]) ?>

    <?= $form->field12md($model, 'answer')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'faq_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Faq::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app', 'Choose Faq')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field12md($model, 'order')->textInput(['placeholder' => $model->getAttributeLabel('order')]) ?>

    <?php /* echo $form->field12md($model, 'content')->textarea(['rows' => 6]) */ ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
