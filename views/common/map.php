<?

use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

$lat = MgHelpers::getSettingTypeText('map lat', false, '52.2296756;51.2296756');
$long = MgHelpers::getSettingTypeText('map long', false, '21.0122287;20.0122287');
$text = MgHelpers::getSettingTypeText('map text', false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');

$lats = explode(';', $lat);
$longs = explode(';', $long);
$texts = explode(';', $text);

if (!isset($lats[0]) || !isset($longs[0]) || !isset($texts[0])) {
    return false;
}

$cssClass = isset($cssClass) ? $cssClass : 'section-map';
$height = isset($height) ? $height : '90vh';
?>

<div class="<?= $cssClass ?>">
    <div id="googlemap" style="height:<?=$height?>" data-lat="<?= $lats[0] ?>" data-lng="<?= $longs[0] ?>"></div>
    <div class="map-points">
        <? foreach ($lats as $i => $lat): ?>
            <div class="map-point" data-lat="<?= $lats[$i] ?>" data-lng="<?= $longs[$i] ?>"
                 data-description="<?= $texts[$i] ?>"></div>
        <? endforeach; ?>

    </div>
</div>
