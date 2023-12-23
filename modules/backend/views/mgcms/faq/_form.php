<?php
use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Faq */
/* @var $form app\components\mgcms\yii\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'FaqItem',
        'relID' => 'faq-item',
        'value' => \yii\helpers\Json::encode($model->faqItems),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);

?>

<div class="faq-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
    <div class="row">

        <?= $form->field12md($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

        <?= $form->field12md($model, 'name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('name')]) ?>

        <?= $form->field6md($model, 'lang')->dropDownList(array_combine(MgHelpers::getConfigParam('languages'), MgHelpers::getConfigParam('languages'))) ?>

        <?= $form->field6md($model, 'type')->dropDownList(\app\models\mgcms\db\Faq::TYPES) ?>
    </div>
    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode(Yii::t('app', 'Pytania/odpowiedzi')),
            'content' => $this->render('_formFaqItem',
                [
                'row' => \yii\helpers\ArrayHelper::toArray($model->faqItems),
            ]),
        ],
    ];
    echo kartik\tabs\TabsX::widget([
        'items' => $forms,
        'position' => kartik\tabs\TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'pluginOptions' => [
            'bordered' => true,
            'sideways' => true,
            'enableCache' => false,
        ],
    ]);

    ?>

    <div class="form-group">
        <?php if (Yii::$app->controller->action->id != 'save-as-new'): ?>
          <?=
          Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
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
