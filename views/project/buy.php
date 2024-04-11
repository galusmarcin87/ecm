<?php
/* @var $project app\models\mgcms\db\Project */
/* @var $payment app\models\mgcms\db\Payment */

/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$amountInPlnPlaceholder = Yii::t('db', 'Value in PLN');
/* @var $form app\components\mgcms\yii\ActiveForm */
$tokenValue = (float)$project->token_value;
$usdToPlnRate = (float)MgHelpers::getSetting('usd_to_pln', false, 1);

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
    <div class="bg-lg-half-decoration py-12 ">
        <div class="container">
            <div class="row">
                <center><h1 class="font-oswald fw-bold mb-6"><?= $project->name ?></h1></center>
                <div class="col-lg-6">
                    <div class="pe-lg-5"><br><br><br>
                        <h4 class="font-oswald fw-bold mb-6">
                            <?= Yii::t('db', 'How many tokens') ?>
                        </h4>
                        <p class="fw-bold bnb-value" id="bnb-value">
                            <?= $form->field($payment, 'actions_amount')->textInput(['placeholder' => $payment->getAttributeLabel('')]) ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-decoration-content">
                        <div class="ps-lg-5"><br><br><br>
                            <div class="row">
                                <div class="col-lg-8 offset-lg-1">
                                    <h4 class="font-oswald fw-bold mb-6"><?= Yii::t('db', 'Value in USD') ?><?= $form->field($payment, 'amount')->textInput(['readonly' => true, 'id' => 'payment-amount', 'placeholder' => $payment->getAttributeLabel('amount')]) ?></h4>
                                </div>
                                <div class="col-lg-8 offset-lg-1">
                                    <h4 class="font-oswald fw-bold mb-6"><?= $amountInPlnPlaceholder ?><?= Html::textInput('amountInPln', '', ['class' => 'form-control', 'id' => 'amountInPln', 'disabled' => true]) ?></h4>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mx-auto">
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
            <div>
                <center>
                    <button type="submit" class="btn btn-primary" name="paymentEngine" value="stripe">
                        <?= Yii::t('db', 'Buy with Stripe') ?>
                    </button>

                    <button type="submit" class="btn btn-primary" name="paymentEngine" value="coinbase">
                        <?= Yii::t('db', 'Buy with Coinbase') ?>
                    </button>

                    <button type="submit" class="btn btn-primary" name="paymentEngine" value="hotpay">
                        <?= Yii::t('db', 'Buy with Hotpay') ?>
                    </button>

                </center>
            </div>
            <br><br><br>
        </div>
    </div>


    <?php ActiveForm::end(); ?>


</div>

<script>
    $(document).ready(function () {
        function updateAmounts() {
            const actionsAmount = parseFloat($('#payment-actions_amount').val()) || 0;
            const tokenValue = <?= $tokenValue ?>;
            const usdToPlnRate = <?= $usdToPlnRate ?>;

            const calculatedAmountInUsd = actionsAmount * tokenValue;
            $('#payment-amount').val(calculatedAmountInUsd.toFixed(2));

            const calculatedAmountInPln = calculatedAmountInUsd * usdToPlnRate;
            $('#amountInPln').val(calculatedAmountInPln.toFixed(2));
        }

        $('#payment-actions_amount').on('change keyup', updateAmounts);

        updateAmounts();
    });
</script>


