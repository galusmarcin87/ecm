<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\mgcms\MgHelpers;
use yii\authclient\widgets\AuthChoice;


$this->title = Yii::t('db', 'Log in');
$fieldConfig = \app\components\ProjectHelper::getFormFieldConfig(true)

//https://yii2-framework.readthedocs.io/en/stable/guide/security-auth-clients/
?>



<?php
$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'contact-form login__form'],
    'fieldConfig' => $fieldConfig
]);

echo $form->errorSummary($model);
?>

<?= $this->render('/common/breadcrumps') ?>

<div class="bg-lg-half-decoration py-7 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="pe-lg-5">
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'options' => ['class' => 'contact-form login__form'],
                                'fieldConfig' => $fieldConfig
                            ]);

                            echo $form->errorSummary($model);
                            ?>

                            <h4 class="font-oswald fw-bold mb-6"><?= Yii::t('db', 'Masz już konto? Zaloguj się') ?></h4>

                            <div class="mb-4">
                                <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
                            </div>

                            <div class="mb-4">
                                <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
                            </div>

                            <div class="text-center my-6">

                                <button class="btn btn-primary btn-wide"
                                        type="submit"><?= Yii::t('db', 'Zaloguj sie') ?></button>
                                <p class="my-4">
                                    <?= Html::a(Yii::t('db', 'Forgotten password?'), ['/site/forgot-password'], ['class' => 'link-dark']) ?>
                                </p>

                            </div>

                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="bg-decoration-content">
                    <div class="ps-lg-5">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-1">

                                <h4 class="font-oswald fw-bold mb-6">
                                    <?= Yii::t('db', 'You dont have an account yet?') ?>
                                </h4>
                                <div class="text-center mb-6">
                                    <a href="<?= \yii\helpers\Url::to('/site/register') ?>"
                                       class="btn btn-primary btn-wide"><?= Yii::t('db', 'Register') ?></a>
                                </div>
                                <p class="text-uppercase mb-4">
                                    <?= Yii::t('db', 'What are benefits?') ?>
                                </p>
                                <?= MgHelpers::getSettingTypeText('login benefits '.Yii::$app->language,true,'<ul class="list-check">
                                    <li>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </li>
                                    <li>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </li>
                                    <li>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </li>
                                </ul>' )?>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

