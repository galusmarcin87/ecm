<?

use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

$lat1 = MgHelpers::getSettingTypeText('map lat 1', false, 52.2296756);
$long1 = MgHelpers::getSettingTypeText('map long 1', false, 21.0122287);
$text1 = MgHelpers::getSettingTypeText('map text 1', false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
$lat2 = MgHelpers::getSettingTypeText('map lat 2', false, 48.856614);
$long2 = MgHelpers::getSettingTypeText('map long 2', false, 2.3522219);
$text2 = MgHelpers::getSettingTypeText('map text 2', false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');

?>

<div class="section-map">
    <div id="googlemap" style="height:90vh" data-lat="<?= $lat1 ?>" data-lng="<?= $long1 ?>"></div>
    <div class="map-points">
        <div class="map-point" data-lat="<?= $lat1 ?>" data-lng="<?= $long1 ?>" data-description="<?= $text1 ?>"></div>
        <div class="map-point" data-lat="<?= $lat2 ?>" data-lng="<?= $long2 ?>" data-description="<?= $text2 ?>"></div>
    </div>
</div>
