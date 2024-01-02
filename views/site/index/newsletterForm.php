<?

use yii\bootstrap\ActiveForm;
use yii\web\View;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */

?>

<div class="section-newsletter" style="background-image:url(/images/newsletter-bg.jpg);">
	<div class="section-content">
		<div class="container">
			<div class="row align-items-center gx-lg-5">
				<div class="col-lg-7">
					<h2 class="section-title text-primary">
						<?= MgHelpers::getSettingTypeText('Home newsletter - text 1 ' . Yii::$app->language, false, 'Strefa inwestora') ?>
					</h2>
					<p class="fs-5 text-uppercase">
						<?= MgHelpers::getSettingTypeText('Home newsletter - text 2 ' . Yii::$app->language, false, 'Bądź zawsze na bieżąco! dołącz do grupy inwestorów i miej możliwość uczestniczenia w naszych najnowszych projektach inwestycyjnych.') ?>
					<form action="#" class="newsletter-form">
						<div class="input-group mb-4">
							<input type="text" class="form-control" placeholder="<?= MgHelpers::getSettingTypeText('Home newsletter - text 3 ' . Yii::$app->language, false, 'Wpisz swój adres e-mail') ?>" aria-label="<?= MgHelpers::getSettingTypeText('Home newsletter - text 4 ' . Yii::$app->language, false, 'Adres email odbiorcy newslettera') ?> ">
							<button class="btn" type="button">
								<?= MgHelpers::getSettingTypeText('Home newsletter - text 5 ' . Yii::$app->language, false, 'Zapisz się') ?> 
                                <svg class="icon">
                                    <use xlink:href="#chevron-right"></use>
                                </svg>
							</button>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="gdpr1">
							<label class="form-check-label" for="gdpr1">
                                <?= MgHelpers::getSettingTypeText('Home newsletter - gdpr 1 ' . Yii::$app->language, false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.') ?>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="gdpr2">
                            <label class="form-check-label" for="gdpr2">
                                 <?= MgHelpers::getSettingTypeText('Home newsletter - gdpr 2 ' . Yii::$app->language, false, 'Wyrażam zgodę na przetwarzanie swoich danych posobowych....') ?> 
                            </label>
                        </div>
					</form>
					</p>
				</div>
				<div class="col-6 col-lg-4 mx-auto">
                <img src="/images/newsletter-invest.png" alt="" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</div>
