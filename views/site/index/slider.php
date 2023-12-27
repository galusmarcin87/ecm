<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$slider = \app\models\mgcms\db\Slider::find()->where(['name' => 'main', 'language' => Yii::$app->language])->one();
if (!$slider) {
    return false;
}

$socialReddit = MgHelpers::getSettingTypeText('slider reddit', false, false);
$socialInstagram = MgHelpers::getSettingTypeText('slider instagram', false, false);
$socialYoutube = MgHelpers::getSettingTypeText('slider youtube', false, false);
$socialFacebook = MgHelpers::getSettingTypeText('slider facebook', false, false);
?>

<div class="container">
    <div class="side-buttons-wrapper">
        <div class="side-buttons">
            <ul class="nav nav-social">
                <? if ($socialReddit): ?>
                    <li class="nav-item">
                        <a href="<?= $socialReddit ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#reddit"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>

                <? if ($socialInstagram): ?>
                    <li class="nav-item">
                        <a href="<?= $socialInstagram ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#instagram"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>

                <? if ($socialYoutube): ?>
                    <li class="nav-item">
                        <a href="<?= $socialYoutube ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#youtube"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>

                <? if ($socialFacebook): ?>
                    <li class="nav-item">
                        <a href="<?= $socialFacebook ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#facebook"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>

            </ul>
        </div>
    </div>
</div>

<div class="slider-section">
    <div class="splide">
        <div class="container">
            <div class="position-relative">
                <div class="splide__track">
                    <ul class="splide__list">
                        <? foreach ($slider->slides as $index => $slide): ?>
                            <li class="splide__slide">
                                <div class="slide-content">
                                    <div class="slide-content-inner">
                                        <div class="row gx-0 px-1 align-items-center">
                                            <div class="col-lg-5 py-4">
                                                <h2 class="font-oswald">
                                                    <?= $slide->header ?>
                                                </h2>
                                                <p>
                                                    <?= $slide->body ?>
                                                </p>
                                                <a href="<?= $slide->link ?>"
                                                   class="btn btn-primary"><?= Yii::t('db', 'See details') ?></a>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <? if ($slide->file && $slide->file->isImage()): ?>
                                                    <img src="<?= $slide->file->getImageSrc() ?>"
                                                         class="img-fluid slider-img"
                                                         alt="">
                                                <? endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <? endforeach; ?>


                    </ul>
                </div>
                <div class="slider-nav">
                    <div class="splide__arrows"></div>
                    <ul class="splide__pagination"></ul>

                </div>
            </div>
        </div>

    </div>
</div>

