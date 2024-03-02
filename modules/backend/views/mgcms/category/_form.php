<?php
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Category */
/* @var $form yii\widgets\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Category',
        'relID' => 'category',
        'value' => \yii\helpers\Json::encode($model->categories),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);

?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <div class="row">
        <div class="col-md-3">
            <?=
            $form->field($model, 'type')->dropDownList(app\components\mgcms\MgHelpers::arrayKeyValueFromArray(\app\models\mgcms\db\Category::TYPES,
                    true), ['maxlength' => true, 'placeholder' => 'Type', 'prompt' => ''])

            ?>
        </div>
        <div class="col-md-3">
            <?=
            $form->field($model, 'parent_id')->widget(\kartik\widgets\Select2::classname(),
                [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Category::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => Yii::t('app', 'Choose Category')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);

            ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'order')->textInput(['placeholder' => 'Order']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'promoted')->switchInput() ?>
        </div>
        <div class="col-md-3">
          <?= $form->field($model, 'language')->dropDownList(array_combine(MgHelpers::getConfigParam('languages'), MgHelpers::getConfigParam('languages'))) ?>
        </div>
        
      
    </div>
    <div class="row">
      <div class="col-md-12">
              <?= $form->relatedFileInput($model, false, true) ?>
              <?= $this->render('/common/relatedFiles', ['model' => $model]) ?>    
          </div>
    </div>

    <? // $form->field($model, 'custom')->textarea(['rows' => 6])  ?>

    <div class="form-group">
        <?=
        Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])

        ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
