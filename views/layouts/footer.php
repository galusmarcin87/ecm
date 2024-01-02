<?

use app\widgets\NobleMenu;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use yii\bootstrap\ActiveForm;

$menu = new NobleMenu(['name' => 'footer_' . Yii::$app->language, 'loginLink' => false]);

$socialReddit = MgHelpers::getSettingTypeText('reddit', false, false);
$socialInstagram = MgHelpers::getSettingTypeText('instagram', false, false);
$socialYoutube = MgHelpers::getSettingTypeText('youtube', false, false);
$socialFacebook = MgHelpers::getSettingTypeText('facebook', false, false);

$mail = MgHelpers::getSettingTypeText('footer mail', false, 'office@ecmarket.eu');
$mail2 = MgHelpers::getSettingTypeText('footer mail 2', false, 'ecminwestors@ecmarket.eu');

?>

<footer class="site-footer">
    <svg class="site-footer-decoration">
        <use xlink:href="#hexagon"/>
    </svg>
    <div class="site-footer-content">
        <div class="container">
            <div class="footer-widgets">
                <div class="row">
                    <div class="col-lg-3 mb-4 mb-lg-0">
                        <img src="/images/logo.svg" width="200" alt="">
                    </div>
                    <div class="col-lg-9">
                        <ul class="nav footer-nav">
                            <? foreach ($menu->getItems() as $item): ?>
                                <li class="nav-item">
                                    <a href="<?= $item['url'] ?>" class="nav-link"><?= $item['label'] ?></a>
                                </li>
                            <? endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-lines">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="d-flex flex-column flex-lg-row align-items-center">
                            <a href="mailto:<?= $mail ?>" class="footer-mail">
                                <div class="footer-mail-icon">
                                    <svg class="icon">
                                        <use xlink:href="#envelope"/>
                                    </svg>
                                </div>
                                <div class="footer-mail-text">
                                    <?= $mail ?>
                                </div>
                            </a>
                            <a href="mailto:<?= $mail2 ?>" class="footer-mail">
                                <div class="footer-mail-icon">
                                    <svg class="icon">
                                        <use xlink:href="#envelope"/>
                                    </svg>
                                </div>
                                <div class="footer-mail-text">
                                    <?= $mail2 ?>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center text-lg-end d-flex">
                        <ul class="nav nav-social mx-auto me-lg-0 ms-lg-auto">


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
            <div class="site-info">
                <div class="row">
                    <div class="col-lg-6">
                        <?= MgHelpers::getSettingTypeText('footer copyright', false,'&copy; 2023 Energy Coin Market Sp. z o.o.') ?>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <?= MgHelpers::getSettingTypeText('footer realization', false,'Realizacja i projekt: <a href="https://vertesdesign.pl/">Vertes Design</a>') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
