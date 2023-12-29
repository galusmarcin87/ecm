<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\web\View;

?>


    <div class="about-section py-5">
    <div class="container">
        <div class="row gx-lg-5">
            <div class="col-lg-5">
                <img src="/images/about-image.png" alt="" class="img-fluid">
            </div>
            <div class="col-lg-6 pe-lg-5 pt-lg-5">
                <h2 class="section-title"> <?= MgHelpers::getSettingTypeText('Home about - title ' . Yii::$app->language, false, 'O nas') ?></h2>
                <p class="text-uppercase">
					<?= MgHelpers::getSettingTypeText('Home about - subtitle ' . Yii::$app->language, false, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. ') ?></h2> 
                </p>
                <p>
					<?= MgHelpers::getSettingTypeText('Home about - text ' . Yii::$app->language, false, 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.') ?>
                    
                </p>
                <a href="<?= MgHelpers::getSettingTypeText('Home about - link 1 url' . Yii::$app->language, false, '#') ?>" class="btn btn-primary">
                        <?= MgHelpers::getSettingTypeText('Home about - link 1 label' . Yii::$app->language, false, 'Czytaj więcej') ?>
                    </a>
            </div>
        </div>
    </div>
</div>
