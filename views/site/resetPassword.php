<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\ChangePasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('db', 'Change password');
$this->params['breadcrumbs'][] = $this->title;
$fieldConfig = \app\components\ProjectHelper::getFormFieldConfig(false)

?>


<section class="Section Section--big-padding-top Contact">
    <div class="container">
        <h1 class="text-center"><?= Yii::t('db', 'Forgotten password'); ?></h1>
        <div class="Contact__grid" style="display: block">
            <div class="Contact-form offset-3 col-md-6">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'class' => 'fadeInUpShort animated delay-250',
                    'fieldConfig' => $fieldConfig
                ]);

                //          echo $form->errorSummary($model);

                ?>

                <div>
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
                </div>
                <div>
                    <?= $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => $model->getAttributeLabel('passwordRepeat')]) ?>
                </div>


                <div class="text-center">
                    <button type="submit" class="btn btn-black" href="#"><?= Yii::t('db', 'Reset'); ?><span></span>
                    </button>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>
