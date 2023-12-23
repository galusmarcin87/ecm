<?php
/* @var $project app\models\mgcms\db\Project */
/* @var $payment app\models\mgcms\db\Payment */

/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;


/* @var $form app\components\mgcms\yii\ActiveForm */


$this->title = Yii::t('db', 'Invest');
$fieldConfig = \app\components\ProjectHelper::getFormFieldConfig(true);

?>

<?= $this->render('/common/breadcrumps') ?>


<div class="container">


    <div class="text-center my-5">
        <img src="/images/logo.png" alt="Opal Crowd" class="img-fluid mx-auto">
    </div>

    <h3 class="my-5 text-center">
        <?= Yii::t('db', 'Fill the data') ?>
    </h3>

    <?php
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'contact-form login__form'],
        'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(false)
    ]);

    echo $form->errorSummary($payment);
    ?>
    <div class="row">
        <div class="col-lg-6 mx-auto">


            <div class="mb-4">
                <?= $form->field($payment, 'amount')->textInput(['placeholder' => $payment->getAttributeLabel('amount')]) ?>
            </div>

            <div class="mb-4">
                <?= $form->field($payment, 'actions_amount')->textInput(['placeholder' => $payment->getAttributeLabel('actions_amount'), 'disabled' => true]) ?>
            </div>


        </div>

    </div>

    <div class="row">
        <div class="col-lg-9 mx-auto">


            <div class="form-check form-check-acceptance mb-3">
                <div class="Form__group form-group text-left checkbox">
                    <?= $form->field($payment, 'acceptTerms',
                        [
                            'checkboxTemplate' => "{input}\n{label}\n{error}",
                            'labelOptions' => ['encode' => false]
                        ]
                    )->checkbox(['class' => 'form-check-input', 'label' => $payment->getAttributeLabel('acceptTerms')])->label(true); ?>
                </div>
            </div>
            <div class="form-check form-check-acceptance mb-3">
                <?= $form->field($payment, 'acceptTerms2',
                    [
                        'checkboxTemplate' => "{input}\n{label}\n{error}",
                        'labelOptions' => ['encode' => false]
                    ]
                )->checkbox(['class' => 'form-check-input', 'label' => $payment->getAttributeLabel('acceptTerms2')])->label(true); ?>
            </div>
            <div class="form-check form-check-acceptance mb-3">
                <?= $form->field($payment, 'acceptTerms3',
                    [
                        'checkboxTemplate' => "{input}\n{label}\n{error}",
                        'labelOptions' => ['encode' => false]
                    ]
                )->checkbox(['class' => 'form-check-input', 'label' => $payment->getAttributeLabel('acceptTerms3')])->label(true); ?>
            </div>
            <div class="form-check form-check-acceptance mb-3">
                <?= $form->field($payment, 'showUserName',
                    [
                        'checkboxTemplate' => "{input}\n{label}\n{error}",
                        'labelOptions' => ['encode' => false]
                    ]
                )->checkbox(['class' => 'form-check-input', 'label' => $payment->getAttributeLabel('showUserName')])->label(true); ?>
            </div>
            <div class="form-check form-check-acceptance mb-3">
                <?= $form->field($payment, 'showUserPhoto',
                    [
                        'checkboxTemplate' => "{input}\n{label}\n{error}",
                        'labelOptions' => ['encode' => false]
                    ]
                )->checkbox(['class' => 'form-check-input', 'label' => $payment->getAttributeLabel('showUserPhoto')])->label(true); ?>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <?= Yii::t('db', 'Buy with TPay') ?>
                </button>
            </div>

        </div>
    </div>


    <?php ActiveForm::end(); ?>


</div>

<script>
    $('#payment-amount').on('change keyup', (function () {
        const tokenValue = <?=(float)$project->token_value?>;
        $('#payment-actions_amount').val(($(this).val()) / tokenValue);
    }));
</script>

