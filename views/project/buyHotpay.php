<?php
/* @var $this yii\web\View */
/* @var $payment \app\models\mgcms\db\Payment */

use app\extensions\mgcms\yii2TinymceWidget\TinyMce;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use \yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use \app\models\mgcms\db\Category;
use kartik\icons\Icon;

$this->title = Yii::t('db', 'Invest by Hotpay');
$FORMULARZ = [
    "SEKRET" => $payment->project->hotpay_sekret,
    "KWOTA" => $payment->amount,
    "NAZWA_USLUGI" => $payment->project,//project name
    "ADRES_WWW" => MgHelpers::getSetting('hotmay www url',false, 'https://ecmarket.vertes-projekty.pl/'),
    "ID_ZAMOWIENIA" => $payment->id,
    "EMAIL" => $payment->user->email ? $payment->user->email : $payment->user->username,
    "DANE_OSOBOWE" => $payment->user,
];

$hasloZUstawien = MgHelpers::getSetting('hotpay haslo',false, 'xxx');

?>
<?= $this->render('/common/breadcrumps') ?>

<section class="companies-wrapper companies-wrapper--dashboard mt-3 mb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                <form id="order" action="https://platnosc.hotpay.pl/" method="post">
                    <?php foreach ($FORMULARZ as $key => $value): ?>
                        <input type="hidden" name="<?= $key ?>" value="<?= $value ?>">
                    <?php endforeach; ?>
                    <?
                    echo '<input name="HASH" required value="'.hash("sha256", $hasloZUstawien.";" . $FORMULARZ["KWOTA"] . ";" . $FORMULARZ["NAZWA_USLUGI"] . ";" . $FORMULARZ["ADRES_WWW"] . ";" . $FORMULARZ["ID_ZAMOWIENIA"] . ";" . $FORMULARZ["SEKRET"]).'" type="hidden">';
                    ?>
                    <input type="submit" value="Zapłać">
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('order').submit();
</script>
