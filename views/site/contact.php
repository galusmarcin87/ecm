<?php
/* @var $this yii\web\View */

/* @var $model \app\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

$this->title = MgHelpers::getSettingTranslated('contact_header', 'Contact');


?>
<?= $this->render('/common/sideSocialButtons') ?>
<?= $this->render('/common/breadcrumps', ['displayBg' => false]) ?>

<div class="contact-page">
    <div class="container">
        <div class="row align-items-center py-6">
            <div class="col-lg-4">

                <div class="contact-info">
                    <div class="contact-info-icon">
                        <svg class="icon">
                            <use xlink:href="#info">
                        </svg>
                    </div>
                    <div class="contact-info-text pt-3">
                        <p>
                            <?= MgHelpers::getSettingTypeText('contact - information' . Yii::$app->language, true) ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info">
                    <div class="contact-info-icon">
                        <svg class="icon">
                            <use xlink:href="#pin">
                        </svg>
                    </div>
                    <div class="contact-info-text pt-3">
                        <?= MgHelpers::getSettingTypeText('contact - address' . Yii::$app->language, true) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-info">
                    <div class="contact-info-icon">
                        <svg class="icon">
                            <use xlink:href="#envelope">
                        </svg>
                    </div>
                    <div class="contact-info-text pt-3">
                        <?= MgHelpers::getSettingTypeText('contact - mail' . Yii::$app->language, true) ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->render('/common/newsletterForm') ?>

<div class="contact-form-section py-6">
    <div class="container">
        <form action="#" class="contact-form">

            <?php
            $form = ActiveForm::begin([
                'id' => 'contact-form',
                'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(true)
            ]);

            echo $form->errorSummary($model);
            ?>

            <h3 class="fw-bold font-oswald text-uppercase mb-5"><?= Yii::t('db', 'Questions?') ?></h3>

            <div class="row">
                <div class="col-lg-10 mx-auto">

                    <div class="mb-4">
                        <?= $form->field($model, 'name')->textInput(['placeholder' => $model->getAttributeLabel('name')]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'phone')->textInput(['placeholder' => $model->getAttributeLabel('phone')]) ?>
                    </div>

                    <div class="mb-4">
                        <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
                    </div>


                    <div class="mb-4">
                        <?= $form->field($model, 'body')->textarea(['placeholder' => $model->getAttributeLabel('body'), 'rows' => 6]) ?>
                    </div>

                    <div class="form-check form-check-acceptance mb-4">
                        <?= $form->field($model, 'acceptTerms', [
                                'options' => [
                                    'class' => "Form__group form-group",
                                ],
                                'checkboxTemplate' => "{input}\n{label}\n{error}",
                            ]
                        )->checkbox(['class' => 'form-check-input']) ?>
                    </div>

                    <div class="form-check form-check-acceptance mb-6">
                        <?= $form->field($model, 'acceptTerms2', [
                                'options' => [
                                    'class' => "Form__group form-group",
                                ],
                                'checkboxTemplate' => "{input}\n{label}\n{error}",
                            ]
                        )->checkbox(['class' => 'form-check-input']) ?>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary btn-wide" type="submit"><?= Yii::t('db', 'Send') ?></button>
                    </div>
                    <?php ActiveForm::end(); ?>


                </div>
            </div>
        </form>
    </div>
</div>
