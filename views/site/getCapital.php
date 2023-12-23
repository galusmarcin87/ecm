<?php
/* @var $this yii\web\View */

/* @var $model \app\models\ContactForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'Get capital');


?>

<div class="text-page">
    <div class="container">
        <div class="text-page-intro">
            <div class="row">
                <div class="col-lg-6">

                    <?= $this->render('/common/breadcrumps') ?>

                    <p class="fs-4">
                        <strong class="fs-3 fw-semibold">
                            <?= MgHelpers::getSettingTypeText('get capital - header 1 ' . Yii::$app->language, false, 'Oferujemy Ci możliwość profesjonalnego
                            zaprezentowania Twojego biznesu, ') ?>

                        </strong><br>
                        <?= MgHelpers::getSettingTypeText('get capital - header 2 ' . Yii::$app->language, false, 'zwalidowania założeń oraz zweryfikowania transakcji.') ?>

                    </p>

                    <?= MgHelpers::getSettingTypeText('get capital - text  ' . Yii::$app->language, true, '<p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p>
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                        pariatur.
                    </p>') ?>


                </div>

                <div class="col-lg-6">
                    <img src="/images/opal4.svg" alt="Zdobądź kapitał" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <div class="bg-green-left">
            <div class="bg-green-left-content">
                <h4 class="fw-light text-uppercase mb-5 font-museo">
                    <?= MgHelpers::getSettingTypeText('get capital - green bar header ' . Yii::$app->language, false, 'Stwórz kampanię:') ?>
                </h4>

                <p class="text-uppercase mb-5 fw-semibold">
                    <?= MgHelpers::getSettingTypeText('get capital - green bar text ' . Yii::$app->language, false, 'Opisz nam swój biznes, przedstaw ofertę inwestycyjną w ramach kampanii i załącz wymagane dokumenty') ?>
                </p>

                <a href="<?= MgHelpers::getSetting('get capital - green bar link ' . Yii::$app->language, false, '#') ?>">
                    <svg class="icon icon-long-arrow">
                        <use xlink:href="#long-right-arrow"/>
                    </svg>
                </a>

            </div>
        </div>
    </div>
    <div class="container">

        <div class="block-media block-media--reverse">
            <div class="block-media-text">
                <h3 class="fw-semibold mb-5">
                    <?= MgHelpers::getSettingTypeText('get capital - 3 section header ' . Yii::$app->language, false, 'Doradzimy jak stworzyć optymalną strategię rozwoju spółki z widocznym potencjałem wyjścia dla
                    inwestorów.') ?>

                </h3>
                <p class="mb-4">
                    <strong>
                        <?= MgHelpers::getSettingTypeText('get capital - 3 section subheader ' . Yii::$app->language, false, 'W celu przeprowadzenia kampanii crodfoundingowej nalezy spełnić następujące warunki:') ?>

                    </strong>
                </p>
                <?= MgHelpers::getSettingTypeText('get capital - 3 section text ' . Yii::$app->language, true, '<p>
                <ol>
                    <li>Produkt lub usługa będzie skutecznie działac na rynku</li>
                    <li>Zespół zmotywowany do pracy</li>
                    <li>Klienci chętni do korzystania z oferowanych produktów lub usług</li>
                    <li>Produkt lub usługa z potencjałem na wzrost</li>
                    <li>Założona spółka P.S.A lub S.A</li>

                </ol>
                </p>') ?>


            </div>
            <div class="block-media-image">
                <img src="/images/opal3.svg" alt="" class="block-media-img">
            </div>
        </div>
    </div>


    <div class="container py-5">
        <div class="bg-light-right">
            <div class="bg-light-right-content">
                <h3 class="fw-semibold mb-5 text-center">
                    <?= MgHelpers::getSettingTypeText('get capital - grey bar header ' . Yii::$app->language, false, 'Platforma OpalCrowd oferuje szansę na dotarcie do wielu imnwestorów. <br/>
                    Dodatkowo jest to doskonałe narzędzie do promocji marketingowej.') ?>

                </h3>


                <div class="advantages">


                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="<?= MgHelpers::getSettingTypeText('get capital - grey bar 1 image ' . Yii::$app->language, false, '/images/icons/prowizja.svg') ?>"
                                 alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('get capital - grey bar 1 label ' . Yii::$app->language, false, '20% prowizji<br>za kompletną usługę') ?>

                        </div>
                    </div>

                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="<?= MgHelpers::getSettingTypeText('get capital - grey bar 2 image ' . Yii::$app->language, false, '/images/icons/wartosc.svg') ?>"
                                 alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('get capital - grey bar 2 label ' . Yii::$app->language, false, 'Wartość') ?>
                        </div>
                    </div>


                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="<?= MgHelpers::getSettingTypeText('get capital - grey bar 3 image ' . Yii::$app->language, false, '/images/icons/walidacja.svg') ?>"
                                 alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('get capital - grey bar 3 label ' . Yii::$app->language, false, 'Walidacja') ?>
                        </div>
                    </div>


                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="<?= MgHelpers::getSettingTypeText('get capital - grey bar 4 image ' . Yii::$app->language, false, '/images/icons/ukryte_koszty.svg') ?>"
                                 alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('get capital - grey bar 4 label ' . Yii::$app->language, false, 'Żadnych dodatkowych<br> ukrytych kosztów') ?>
                        </div>
                    </div>


                    <div class="advantages-item">
                        <div class="advantages-icon">
                            <img src="<?= MgHelpers::getSettingTypeText('get capital - grey bar 5 image ' . Yii::$app->language, false, '/images/icons/zysk.svg') ?>"
                                 alt="">
                        </div>
                        <div class="advantages-title">
                            <?= MgHelpers::getSettingTypeText('get capital - grey bar 5 label ' . Yii::$app->language, false, 'Jedna wizyta u notariusza<br> daje możliwość otrzymania<br> kapitału od wielu inwestorów') ?>
                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>


</div>
