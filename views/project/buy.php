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

<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text']) ?>


<div class="container mb-3">

    <?php
    $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'contact-form login__form'],
        'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(true)
    ]);

    echo $form->errorSummary($payment);
    ?>
	<div class="bg-lg-half-decoration py-6 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="pe-lg-5">
                    <h4 class="font-oswald fw-bold mb-6"><?= Yii::t('db', 'Enter the amount') ?></h4>
                    <div class="mb-6">
                        <?= $form->field($payment, 'amount')->textInput(['placeholder' => $payment->getAttributeLabel('amount')]) ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-5">
                    <h4 class="font-oswald fw-bold mb-6">
                       <?= Yii::t('db', 'value in tokens') ?>
                    </h4>
                    <p class="fw-bold bnb-value" id="bnb-value"><?= $form->field($payment, 'actions_amount')->textInput(['placeholder' => $payment->getAttributeLabel(''), 'disabled' => true]) ?></p>
                </div>
            </div>
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
            <div class="text-end">
                <button type="submit" class="btn btn-primary" name="paymentEngine" value="coinbase">
                    <?= Yii::t('db', 'Buy with coinbase') ?>
                </button>

                <button type="submit" class="btn btn-primary" name="paymentEngine" value="hotpay">
                    <?= Yii::t('db', 'Buy with hotpay') ?>
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

