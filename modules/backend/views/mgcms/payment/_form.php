<?php
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Payment */
/* @var $form app\components\mgcms\yii\ActiveForm */

?>

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <?= $form->field12md($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

        <?=
        $form->field6md($model, 'project_id')->widget(\kartik\widgets\Select2::classname(),
            [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Project::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
            'options' => ['placeholder' => Yii::t('app', 'Choose Project')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

        ?>

        <?=
        $form->field6md($model, 'user_id')->widget(\kartik\widgets\Select2::classname(),
            [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\User::find()->orderBy('id')->all(), 'id', 'toString'),
            'options' => ['placeholder' => Yii::t('app', 'Choose User')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);

        ?>
      
        <?= $form->field12md($model, 'terms', ['template' => '{input}'])->textInput(['style' => 'display:none','value'=>1]); ?>

        <?= $form->field6md($model, 'amount')->textInput(['placeholder' => $model->getAttributeLabel('amount')]) ?>

        <?= $form->field6md($model, 'status')->dropDownList(app\models\mgcms\db\Payment::STATUSES) ?>

        <div class="hidden">
        <?= $form->field6md($model, 'percentage')->textInput(['placeholder' => $model->getAttributeLabel('percentage')]) ?>

        <?= $form->field6md($model, 'is_preico')->switchInput() ?>

        <?= $form->field12md($model, 'user_token')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('user_token')]) ?>

      
      <?= $form->field12md($model, 'comments')->textarea() ?>

        </div>

    </div>
    <div class="form-group">
        <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
          <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
              ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])

          ?>
        <?php endif; ?>
        <?php if (Yii::$app->controller->action->id != 'create'): ?>
          <?= Html::submitButton(Yii::t('app', 'Save As New'), ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
<?php endif; ?>
    <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
