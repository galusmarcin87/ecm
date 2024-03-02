<?php
/* @var $this yii\web\View */
/* @var $project \app\models\mgcms\db\Project */

use app\extensions\mgcms\yii2TinymceWidget\TinyMce;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use \yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use \app\models\mgcms\db\Category;
use kartik\icons\Icon;
$this->title = Yii::t('db', 'Invest by Stripe');

?>
<script src="https://js.stripe.com/v3/"></script>
<?= $this->render('/common/breadcrumps') ?>

<section class="companies-wrapper companies-wrapper--dashboard mt-3 mb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                <form id="payment-form" data-secret="<?= $clientSecret ?>">
                    <div id="payment-element">
                        <!-- Elements will create form elements here -->
                    </div>

                    <div class="text-center mt-2    ">
                        <button id="submit" class="btn btn-primary"><?= Yii::t('db', 'Pay with Stripe') ?></button>
                    </div>


                    <div id="error-message">
                        <!-- Display error message to your customers here -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<script>
    const stripe = Stripe(
      '<?= MgHelpers::getSetting('stripe api publishable key '.$project->type, false, 'pk_test_51OCLLOIqVuogZFUBSFWzfSjzt3pEOWvvDvZhChUctT7vJAzgH6w9l8hZzPUyNsFlf9GWEyyVngvfBnQLq1u9Xt5h00gGLaalEz');?>',
      {
          stripeAccount: '<?= $stripeAccount?>',
      });
    const options = {
        clientSecret: '<?= $clientSecret ?>',
        // Fully customizable with appearance API.
        appearance: {/*...*/ },
    };

    // Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 2
    const elements = stripe.elements(options);

    // Create and mount the Payment Element
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { error } = await stripe.confirmPayment({
            //`Elements` instance that was used to create the Payment Element
            elements,
            confirmParams: {
                return_url: '<?= $returnUrl?>',
            },
        });

        if (error) {
            const messageContainer = document.querySelector('#error-message');
            messageContainer.textContent = error.message;
        }
        else {
        }
    });


</script>

