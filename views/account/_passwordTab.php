<?php
/* @var $this yii\web\View */
/* @var $model \app\models\mgcms\db\User */

use yii\bootstrap\ActiveForm;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'My data');


?>

<?= $this->render('/common/breadcrumps') ?>
<?= $this->render('_investor') ?>



<div class="account-page">
    <div class="container">


        <div class="row gx-4">
            <?= $this->render('_leftNav', ['tab' => $tab]) ?>


            <div class="col-lg-10 account-content-col">

                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'class' => 'form-light',
                    'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(true)
                ]);
                echo $form->errorSummary($model);
                ?>


                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <?= $form->field($model, 'oldPassword')->passwordInput(['placeholder' => $model->getAttributeLabel('oldPassword')]) ?>

                            <?= $form->field($model, 'newPassword')->passwordInput(['placeholder' => $model->getAttributeLabel('newPassword')]) ?>

                            <?= $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => $model->getAttributeLabel('passwordRepeat')]) ?>



                            <div class="password-stregth my-5 hidden">
                                <p>
                                    <strong>siła hasła:</strong> ŚREDNIE
                                </p>
                                <div class="progress" role="progressbar" aria-label="Basic example"
                                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: 50%"></div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="text-end">
                        <button type="submit" name="passwordChanging" class="btn btn-primary"><?= Yii::t('db', 'Save changes') ?></button>
                    </div>


                <?php ActiveForm::end(); ?>


            </div>


        </div>


    </div>


</div>
