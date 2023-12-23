<?

use app\components\mgcms\yii\ActiveForm;
use kartik\widgets\StarRating;

/* @var $this View */
/* @var $model \app\models\mgcms\db\Product | \app\models\mgcms\db\Service */

$payment = $model->getRatePayment();
$options = [
    'step' => 1,
    'stars' => 8,
    'showClear' => false,
    'showCaption' => false,
    'max' => 8,
    'filledStar' => '<i class="fa fa-star rating__star rating__star--active"  aria-hidden="true"></i>',
    'emptyStar' => '<i class="fa fa-star rating__star"  aria-hidden="true"></i>',
    'defaultCaption' => '{rating} hearts',
];

$toRate = $payment && !$payment->rate;
if (!$toRate) {
    $options['readonly'] = true;
}


?>

<div class="rating">

    <?php $form = ActiveForm::begin([
        'id' => 'rate-form',
        'options' => ['class' => 'form'],
    ]); ?>

    <? if ($toRate): ?>
        <?= $form->field($payment, 'rate')->widget(StarRating::classname(), [
            'pluginOptions' => $options,
            'value' => $model->rating,
        ]); ?>
    <? else: ?>
        <?= StarRating::widget([
            'name' => 'rating_21',
            'value' => $model->rating,
            'pluginOptions' => $options
        ]);
        ?>
    <? endif ?>

    <?php ActiveForm::end(); ?>


    <? if ($toRate): ?>
        <script>
            $('#payment-rate').change(function () {
                $('#rate-form').submit();
                3;
            });
        </script>
    <? endif ?>

</div>
