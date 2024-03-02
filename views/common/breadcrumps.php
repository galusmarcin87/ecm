<?php
use yii\web\View;

/* @var $this yii\web\View */
$displayBg = isset($displayBg) ? $displayBg : true;
$cssClass = isset($cssClass) ? $cssClass : 'page-header';

$currentUrl = Yii::$app->request->url;
$backgroundImage = isset($backgroundImage) && $backgroundImage ? $backgroundImage : '/images/page-header.jpg'; // Domyślny obraz tła

if ($currentUrl == '/art/o-nas') {
    $backgroundImage = '/images/o_ecm_tlo.jpg'; // Ścieżka do obrazu tła dla /art/o-nas
} elseif ($currentUrl == '/art/jak-zainwestowac') {
    $backgroundImage = '/images/jak_zainwestowac_tlo.jpg'; // Ścieżka do obrazu tła dla /art/jak-zainwestowac
} elseif ($currentUrl == '/faq/index?id=1') {
    $backgroundImage = '/images/faq_tlo.jpg'; // Ścieżka do obrazu tła dla /art/jak-zainwestowac
} elseif ($currentUrl == '/art/mr-mega-watt') {
    $backgroundImage = '/images/mrmega_watt_tlo.jpg'; // Ścieżka do obrazu tła dla /art/jak-zainwestowac
}
?>

<div class="<?= $cssClass ?>" <?php if ($displayBg): ?>style="position: relative; background-image: url('<?= $backgroundImage ?>');"<?php endif; ?>>
    <!-- Nakładka umieszczona pod zawartością strony -->
    <div class="overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.6); z-index: 0;"></div>

    <!-- Zawartość strony umieszczona powyżej nakładki -->
    <div class="page-header-content" style="position: relative; z-index: 2;">
        <div class="container">
            <h1 class="page-header-title" style="font-family: 'Oswald', sans-serif;"><?= $this->title ?></h1>
            <div class="breadcrumbs">
            </div>
        </div>
    </div>
</div><br><br>
