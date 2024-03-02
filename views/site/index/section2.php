<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\web\View;


?>
<div class="about-section py-5">
	<div class="container py-5">
		<div class="row gx-lg-5">
			<div class="col-lg-5"><br><br>
                <img src="/images/about-image2.png" alt="" class="img-fluid">
            </div>
			<div class="col-lg-6 pe-lg-5 pt-lg-5">
                <h2 class="text-uppercase">
					<?= MgHelpers::getSettingTypeText('Home section 2 - text 1 ' . Yii::$app->language, false, 'tokenizacja') ?> <span class="text-primary"><?= MgHelpers::getSettingTypeText('Home section 2 - text 2 ' . Yii::$app->language, false, 'rewolucjonizuje 
                    rynek') ?></span>  <?= MgHelpers::getSettingTypeText('Home section 2 - text 3 ' . Yii::$app->language, false, 'fotowoltaiki,') ?>
                </h2>
				<p class="fs-4"><?= MgHelpers::getSettingTypeText('Home section 2 - text 4 ' . Yii::$app->language, false, 'umożliwiając inwestycję w projekty fotowoltaiczne w sposób zdecentralizowany i bardziej dostępny dla inwestorów.') ?>
				</p>
				<p>
					<?= MgHelpers::getSettingTypeText('Home section 2 - text 5 ' . Yii::$app->language, false, 'Dzięki temu, inwestycje w fotowoltaikę stają się bardziej transparentne i elastyczne, a inwestorzy mają większy wpływ na procesy związane z produkcją energii słonecznej. Tokeny oparte na technologii blockchain pozwalają na bezpieczne i efektywne zarządzanie inwestycją oraz śledzenie wykorzystania środków, co przyczynia się do zwiększenia zaufania inwestorów do projektów fotowoltaicznych. ') ?>
				</p>
				<p>
					<?= MgHelpers::getSettingTypeText('Home section 2 - text 6 ' . Yii::$app->language, false, 'W ten sposób, tokenizacja może odegrać kluczową rolę w dalszym rozwoju i upowszechnieniu fotowoltaiki jako źródła czystej energii.') ?>
                </p>
            </div>
        </div>
    </div>
</div>
