<?php

use yii\helpers\Html;
use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;
use \app\models\mgcms\db\FileRelation;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Project */
/* @var $form app\components\mgcms\yii\ActiveForm */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Bonus',
        'relID' => 'bonus',
        'value' => \yii\helpers\Json::encode($model->bonuses),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);


\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos' => \yii\web\View::POS_END,
    'viewParams' => [
        'class' => 'Faq',
        'relID' => 'faq',
        'value' => \yii\helpers\Json::encode($model->faqs),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
yii\jui\JuiAsset::register($this);
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <?= $this->render('/common/languageBehaviorSwicher', ['model' => $model, 'form' => $form]) ?>

        <?= $form->field3md($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field3md($model, 'status')->dropDownList(\app\models\mgcms\db\Project::STATUSES) ?>
        <?= $form->field3md($model, 'type')->dropDownList(MgHelpers::arrayKeyValueFromArray(\app\models\mgcms\db\Project::TYPES)) ?>

        <div class="row">
            <?= $form->field3md($model, 'file_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('id')->asArray()->all(), 'id', 'origin_name'),
                'options' => ['placeholder' => Yii::t('app', 'Choose File')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>

        <?= $form->field3md($model, 'money')->textInput(['placeholder' => '']) ?>

        <?= $form->field3md($model, 'money_full')->textInput(['placeholder' => '']) ?>

        <?= $form->field3md($model, 'token_name')->textInput(['placeholder' => '']) ?>

        <?= $form->field3md($model, 'token_value')->textInput(['placeholder' => '']) ?>

        <?= $form->field3md($model, 'token_minimal_buy')->textInput(['placeholder' => '']) ?>

        <?= $form->field4md($model, 'date_presale_start')->widget(\kartik\datecontrol\DateControl::classname(), [
            'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
            'saveFormat' => 'php:Y-m-d',
            'ajaxConversion' => true,
            'options' => [
                'pluginOptions' => [
                    'placeholder' => Yii::t('app', 'Choose Date Crowdsale Start'),
                    'autoclose' => true
                ]
            ],
        ]); ?>

        <?= $form->field4md($model, 'date_presale_end')->widget(\kartik\datecontrol\DateControl::classname(), [
            'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
            'saveFormat' => 'php:Y-m-d',
            'ajaxConversion' => true,
            'options' => [
                'pluginOptions' => [
                    'placeholder' => Yii::t('app', 'Choose Date Crowdsale End'),
                    'autoclose' => true
                ]
            ],
        ]); ?>

        <?= $form->field4md($model, 'date_crowdsale_start')->widget(\kartik\datecontrol\DateControl::classname(), [
            'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
            'saveFormat' => 'php:Y-m-d',
            'ajaxConversion' => true,
            'options' => [
                'pluginOptions' => [
                    'placeholder' => Yii::t('app', 'Choose Date Crowdsale Start'),
                    'autoclose' => true
                ]
            ],
        ]); ?>

        <?= $form->field4md($model, 'date_crowdsale_end')->widget(\kartik\datecontrol\DateControl::classname(), [
            'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
            'saveFormat' => 'php:Y-m-d',
            'ajaxConversion' => true,
            'options' => [
                'pluginOptions' => [
                    'placeholder' => Yii::t('app', 'Choose Date Crowdsale End'),
                    'autoclose' => true
                ]
            ],
        ]); ?>


        <?= $form->field4md($model, 'percentage')->textInput(['placeholder' => '']) ?>
        <?= $form->field4md($model, 'investition_time')->textInput(['placeholder' => '']) ?>
        <?= $form->field6md($model, 'token_minimal_buy')->textInput(['placeholder' => '']) ?>
        <?= $form->field6md($model, 'percentage_presale_bonus')->textInput(['placeholder' => '']) ?>

        <? if (MgHelpers::getUserModel()->role === 'admin'): ?>
            <?= $form->field4md($model, 'created_by')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\User::find()->orderBy('id')->all(), 'id', 'toString'),
                'options' => ['placeholder' => Yii::t('app', 'Wybierz użytkownika')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        <? endif ?>

        <?= $form->field6md($model, 'localization')->textInput(['maxlength' => true, 'placeholder' => 'Localization']) ?>

        <?= $form->field6md($model, 'gps_lat')->textInput(['maxlength' => true, 'placeholder' => 'Gps Lat']) ?>

        <?= $form->field6md($model, 'gps_long')->textInput(['maxlength' => true, 'placeholder' => 'Gps Long']) ?>

        <?= $form->field12md($model, 'lead')->tinyMce() ?>

        <?= $form->field12md($model, 'text')->tinyMce() ?>

        <?= $form->field3md($model, 'fiber_collect_id')->textInput(['placeholder' => '']) ?>
        <?= $form->field3md($model, 'iban')->textInput(['placeholder' => '']) ?>
        <?= $form->field3md($model, 'pay_name')->textInput(['placeholder' => '']) ?>
        <?= $form->field3md($model, 'pay_description')->textInput(['placeholder' => '']) ?>

    </div>

    <div class="well">
        <div class="col-md-12">
            <?= $form->relatedFileInput($model, true, true) ?>
        </div>

        <legend><?= Yii::t('app', 'Images'); ?></legend>
        <? /*---------------specyfic for this project distinguish between files ------------------*/ ?>
        <div class="row images itemsFlex">
            <? foreach ($model->fileRelations as $relation): ?>

                <? if ($relation->json == '1' || !$relation->file) continue ?>
                <div class="col-md-3 center bottom10">
                    <?= \kartik\helpers\Html::hiddenInput("fileOrder[" . $relation->file->id . "]") ?>
                    <? echo \yii\helpers\Html::a(Icon::show('trash', ['class' => 'gi-2x']), MgHelpers::createUrl(['backend/mgcms/file/delete-relation', 'relId' => $model->id, 'fileId' => $relation->file->id, 'model' => $model::className()]), ['onclick' => 'return confirm("' . Yii::t('app', 'Are you sure?') . '")', 'class' => 'deleteLink']) ?>
                    <?= $relation->file->getThumb(250, 250, true, \Imagine\Image\ManipulatorInterface::THUMBNAIL_INSET, ['class' => 'img-responsive']) ?>
                    <? \kartik\helpers\Html::textarea("FileRelation[$relation->file->id][$model->id][" . $model::className() . "][description]", 'aaa', ['class' => 'form-control']) ?>
                </div>
            <? endforeach ?>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $('.images').sortable()
            })

        </script>
    </div>


    <div class="col-md-12">
        <?= $form->field($model, 'downloadFiles[]')->fileInput(['multiple' => true]) ?>
        <legend><?= Yii::t('app', 'Files to download'); ?></legend>
        <? foreach ($model->fileRelations as $relation): ?>
            <? if ($relation->json != '1' || !$relation->file) continue ?>
            <div class="col-md-3 center bottom10">
                <? echo \yii\helpers\Html::a(Icon::show('trash', ['class' => 'gi-2x']), MgHelpers::createUrl(['backend/mgcms/file/delete-relation', 'relId' => $model->id, 'fileId' => $relation->file->id, 'model' => $model::className()]), ['onclick' => 'return confirm("' . Yii::t('app', 'Are you sure?') . '")', 'class' => 'deleteLink']) ?>
                <?= Html::a($relation->file->origin_name, $relation->file->linkUrl) ?>

            </div>
        <? endforeach ?>
    </div>

    <?php
    $forms = [
        [
            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode(Yii::t('app', 'Roadmap')),
            'content' => $this->render('_formBonus', [
                'row' => \yii\helpers\ArrayHelper::toArray($model->bonuses),
            ])
        ],
//        [
//
//            'label' => '<i class="glyphicon glyphicon-book"></i> ' . Html::encode(Yii::t('app', 'FAQ')),
//            'content' => $this->render('_formFaq', [
//                'row' => \yii\helpers\ArrayHelper::toArray($model->faqs),
//            ]),
//        ],
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
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif; ?>
        <?php if (Yii::$app->controller->action->id != 'create'): ?>
            <?= Html::submitButton(Yii::t('app', 'Save As New'), ['class' => 'btn btn-info', 'value' => '1', 'name' => '_asnew']) ?>
        <?php endif; ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
