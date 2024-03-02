<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\web\View;


?>

<div class="section-how" style="background-image:url(/images/howto-bg.jpg);">
<div class="section-content">
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<h2 class="section-title text-primary">
				<?= MgHelpers::getSettingTypeText('Home section 1 - title ' . Yii::$app->language, false, 'Jak zainwestować?') ?>
			</h2>
			<p class="fs-2">
				<?= MgHelpers::getSettingTypeText('Home section 1 - subtitle ' . Yii::$app->language, false, 'Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. ') ?>  
			</p>
			<div class="my-5 d-flex flex-column flex-md-row">
				<a href="<?= MgHelpers::getSettingTypeText('Home section 1 - link 1 url' . Yii::$app->language, false, '#') ?>" class="btn btn-wide btn-primary mb-3 mb-md-0 me-md-3">
					<?= MgHelpers::getSettingTypeText('Home section 1 - link 1 label' . Yii::$app->language, false, 'Dowiedz się więcej') ?>
				</a>
				<a href="<?= MgHelpers::getSettingTypeText('Home section 1 - link 2 url' . Yii::$app->language, false, '#') ?>" class="btn btn-wide btn-dark"> <?= MgHelpers::getSettingTypeText('Home section 1 - link 2 label' . Yii::$app->language, false, 'Załóż konto') ?>
				</a>
			</div>
			<p class="fs-5"><?= MgHelpers::getSettingTypeText('Home section 1 - text ' . Yii::$app->language, false, 'Masz już konto?') ?> 
				<a href="<?= MgHelpers::getSettingTypeText('Home section 1 - link 3 url' . Yii::$app->language, false, '#') ?>" class="link-light fw-bold"> <?= MgHelpers::getSettingTypeText('Home section 1 - link 3 label' . Yii::$app->language, false, 'Zaloguj się') ?> </a></p>
		</div>
		<div class="col-4 col-lg-3 pt-lg-5 pt-5 mx-auto text-center">
			<img src="/images/question-mark.png" alt="" class="img-fluid mx-auto">
		</div>
	</div>
	</div>
	</div>
</div>