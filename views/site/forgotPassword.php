<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\ForgotPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('db', 'Forgotten password');

$fieldConfig = \app\components\ProjectHelper::getFormFieldConfig(false)
?>
<?= $this->render('/common/breadcrumps')?>

<section class="Section Section--big-padding-top Contact">
    <div class="container">
        <h1 class="text-center"><?= Yii::t('db', 'Forgotten password'); ?></h1>
        <div class="Contact__grid" style="display: block">
            <div class="Contact-form offset-3 col-md-6">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldConfig' => $fieldConfig
                ]);

                //          echo $form->errorSummary($model);

                ?>

                <div class="">
                        <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t('db','Your email')]) ?>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success" href="#"><?= Yii::t('db', 'Send'); ?><span></span>
                    </button>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>

