<?php
/* @var $this yii\web\View */

/* @var $model \app\models\mgcms\db\User */

use yii\bootstrap\ActiveForm;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'My data');


?>

<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text', ]) ?>
<?= $this->render('_investor') ?>

<div class="account-page">
    <div class="container">


        <div class="row gx-4">
            <?= $this->render('_leftNav', ['tab' => $tab]) ?>
            <div class="col-lg-9 account-content-col">

                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'class' => 'fadeInUpShort animated delay-250',
                    'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(false)
                ]);
                echo $form->errorSummary($model);
                ?>

                <div>
                    <h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'Identification data') ?></h4>

                    <div class="row">

						<div class="col-lg-4">
                            <?= $form->field($model, 'first_name')->textInput(['placeholder' => $model->getAttributeLabel('first_name')]) ?>
                        </div>
						<div class="col-lg-4">
                            <?= $form->field($model, 'last_name')->textInput(['placeholder' => $model->getAttributeLabel('last_name')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'phone')->textInput(['placeholder' => $model->getAttributeLabel('phone')]) ?>
                        </div>
						<div class="col-lg-4">
                            <?= $form->field($model, 'pesel')->textInput(['placeholder' => $model->getAttributeLabel('pesel')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'company_name')->textInput(['placeholder' => $model->getAttributeLabel('company_name')]) ?>
                        </div>
                    </div>
                </div><br><br>
                <div class="account-data-block">
                        <h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'Address') ?></h4>
                    <div class="row">

                        <div class="col-lg-4">
                            <?= $form->field($model, 'city')->textInput(['placeholder' => $model->getAttributeLabel('city')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'street')->textInput(['placeholder' => $model->getAttributeLabel('street')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'house_no')->textInput(['placeholder' => $model->getAttributeLabel('house_no')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'flat_no')->textInput(['placeholder' => $model->getAttributeLabel('flat_no')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'postcode')->textInput(['placeholder' => $model->getAttributeLabel('postcode')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'country')->textInput(['placeholder' => $model->getAttributeLabel('country')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'voivodeship')->textInput(['placeholder' => $model->getAttributeLabel('voivodeship')]) ?>
                        </div>
                    </div>

                </div><br><br>
                <div class="account-data-block">
                        <h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'Correspondence address') ?></h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <?= $form->field($model, 'cor_city')->textInput(['placeholder' => $model->getAttributeLabel('cor_city')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'cor_street')->textInput(['placeholder' => $model->getAttributeLabel('cor_street')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'cor_house_no')->textInput(['placeholder' => $model->getAttributeLabel('cor_house_no')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'cor_flat_no')->textInput(['placeholder' => $model->getAttributeLabel('cor_flat_no')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'cor_postcode')->textInput(['placeholder' => $model->getAttributeLabel('cor_postcode')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'cor_country')->textInput(['placeholder' => $model->getAttributeLabel('cor_country')]) ?>
                        </div>
                        <div class="col-lg-4">
                            <?= $form->field($model, 'cor_voivodeship')->textInput(['placeholder' => $model->getAttributeLabel('cor_voivodeship')]) ?>
                        </div>
                    </div>
                </div><br><br>
				<div class="account-data-block">
                        <h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'Bank number') ?></h4>
                    <div class="row">
                        <?= $form->field($model, 'bank_no')->textInput(['placeholder' => $model->getAttributeLabel('bank_no')]) ?> 
                    </div>
                </div><br><br>

                <div class="account-data-block">
                        <h4 class="font-oswald fw-bold mb-4"><?= Yii::t('db', 'Photo') ?></h4>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="row align-items-center">
                                <? if ($model->file && $model->file->isImage()): ?>
                                    <div class="col-4">
                                        <img src="<?= $model->file->getImageSrc(95, 95) ?>" alt="OC" class="avatar-img">
                                    </div>
                                <? endif; ?>
                                <div class="col-8">
                                    <?= $form->field($model, 'fileUpload')->fileInput(['multiple' => true, 'accept' => '.jpg,.jpeg,.png', 'class' => 'inputfile']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><?= Yii::t('db', 'Save changes') ?></button>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div><br><br>
