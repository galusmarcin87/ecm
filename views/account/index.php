<?php
/* @var $this yii\web\View */

/* @var $myCompany \app\models\mgcms\db\Company */

use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use \yii\helpers\Url;

$this->title = Yii::t('db', 'Main panel');
$this->params['breadcrumbs'][] = ['/account', Yii::t('db', 'My Account')];
?>

<?= $this->render('/common/breadcrumps') ?>

<div class="account-page">
    <div class="container">


        <div class="row gx-4">
            <div class="col-lg-2 account-sidebar-col">


                <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="offcanvasAccount"
                     aria-labelledby="offcanvasAccountLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExaoffcanvasAccountLabelmpleLabel">Moje konto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">


                        <?= $this->render('_leftNav')?>

                    </div>
                </div>
            </div>
            <div class="col-lg-8 account-content-col">


                <div class="account-main-block">

                    <h2 class="section-title section-title--small">
                        Najnowsza emisja
                    </h2>

                    <div class="row align-items-center">
                        <div class="col-lg-6">

                            <a class="card card-campaign mb-3" href="kampania.html">
                                <div class="card-main-image img-rounded-right-top">
                                    <img src="assets/images/photo1.jpg" class="card-img-top" alt="Token">
                                    <div class="card-main-image-overlay">
                                        <span>Zobacz więcej</span>
                                    </div>
                                    <div class="card-main-image-flags">
                                        <strong>2</strong> Inwestycje
                                    </div>
                                    <div class="card-main-image-like">
                                        <svg class="icon">
                                            <use xlink:href="#like-outline"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title card-title--campaign">
                                        SDT Lab One
                                    </h5>

                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>

                                    <div class="card-progress">
                                        <div class="row">
                                            <div class="col-6">
                                                <p>Zebrane (50%):</p>
                                                <p class="fs-6"><strong>167 tys. PLN</strong></p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p>Cel:</p>
                                                <p class="fs-6">700 tys. PLN</p>
                                            </div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Basic example"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>

                                    </div>

                                    <div class="campaign-countdown">
                                        <p class="text-uppercase">
                                            <strong>Pozostało:</strong>
                                        </p>
                                        <div class="countdown" data-date="24-9-2023" data-time="23:00">
                                            <div class="day"><span class="num"></span><span class="word"> dni</span>
                                            </div>
                                            <div class="hour"><span class="num"></span><span class="word"> godzin</span>
                                            </div>
                                            <div class="min"><span class="num"></span><span class="word"> minut</span>
                                            </div>
                                            <div class="sec"><span class="num"></span><span class="word"> sekund</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>


                        </div>
                        <div class="col-lg-6">


                            <a class="cta cta--style1" href="#">
            <span class="cta-large">
              Zobacz nową&nbsp;emisję
            </span>
                                <span class="cta-small">
              Zainwestuj już teraz!
            </span>
                                <svg class="icon icon-long-arrow">
                                    <use xlink:href="#long-right-arrow"/>
                                </svg>
                            </a>

                        </div>
                    </div>

                </div>


                <div class="account-main-block">
                    <h2 class="section-title section-title--small">
                        Wszystkie kampanie
                    </h2>
                    <div class="row gy-5">
                        <div class="col-lg-6">

                            <a class="card card-campaign mb-3" href="kampania.html">
                                <div class="card-main-image img-rounded-right-top">
                                    <img src="assets/images/photo1.jpg" class="card-img-top" alt="Token">
                                    <div class="card-main-image-overlay">
                                        <span>Zobacz więcej</span>
                                    </div>
                                    <div class="card-main-image-flags">
                                        <strong>2</strong> Inwestycje
                                    </div>
                                    <div class="card-main-image-like">
                                        <svg class="icon">
                                            <use xlink:href="#like-outline"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title card-title--campaign">
                                        SDT Lab One
                                    </h5>

                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>

                                    <div class="card-progress">
                                        <div class="row">
                                            <div class="col-6">
                                                <p>Zebrane (50%):</p>
                                                <p class="fs-6"><strong>167 tys. PLN</strong></p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p>Cel:</p>
                                                <p class="fs-6">700 tys. PLN</p>
                                            </div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Basic example"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>

                                    </div>

                                    <div class="campaign-countdown">
                                        <p class="text-uppercase">
                                            <strong>Pozostało:</strong>
                                        </p>
                                        <div class="countdown" data-date="24-9-2023" data-time="23:00">
                                            <div class="day"><span class="num"></span><span class="word"> dni</span>
                                            </div>
                                            <div class="hour"><span class="num"></span><span class="word"> godzin</span>
                                            </div>
                                            <div class="min"><span class="num"></span><span class="word"> minut</span>
                                            </div>
                                            <div class="sec"><span class="num"></span><span class="word"> sekund</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>


                        </div>
                        <div class="col-lg-6">

                            <a class="card card-campaign mb-3" href="kampania.html">
                                <div class="card-main-image img-rounded-right-top">
                                    <img src="assets/images/photo1.jpg" class="card-img-top" alt="Token">
                                    <div class="card-main-image-overlay">
                                        <span>Zobacz więcej</span>
                                    </div>
                                    <div class="card-main-image-flags">
                                        <strong>2</strong> Inwestycje
                                    </div>
                                    <div class="card-main-image-like">
                                        <svg class="icon">
                                            <use xlink:href="#like-outline"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title card-title--campaign">
                                        SDT Lab One
                                    </h5>

                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>

                                    <div class="card-progress">
                                        <div class="row">
                                            <div class="col-6">
                                                <p>Zebrane (50%):</p>
                                                <p class="fs-6"><strong>167 tys. PLN</strong></p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p>Cel:</p>
                                                <p class="fs-6">700 tys. PLN</p>
                                            </div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Basic example"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>

                                    </div>

                                    <div class="campaign-countdown">
                                        <p class="text-uppercase">
                                            <strong>Pozostało:</strong>
                                        </p>
                                        <div class="countdown" data-date="24-9-2023" data-time="23:00">
                                            <div class="day"><span class="num"></span><span class="word"> dni</span>
                                            </div>
                                            <div class="hour"><span class="num"></span><span class="word"> godzin</span>
                                            </div>
                                            <div class="min"><span class="num"></span><span class="word"> minut</span>
                                            </div>
                                            <div class="sec"><span class="num"></span><span class="word"> sekund</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>


                        </div>
                        <div class="col-lg-6">

                            <a class="card card-campaign mb-3" href="kampania.html">
                                <div class="card-main-image img-rounded-right-top">
                                    <img src="assets/images/photo1.jpg" class="card-img-top" alt="Token">
                                    <div class="card-main-image-overlay">
                                        <span>Zobacz więcej</span>
                                    </div>
                                    <div class="card-main-image-flags">
                                        <strong>2</strong> Inwestycje
                                    </div>
                                    <div class="card-main-image-like">
                                        <svg class="icon">
                                            <use xlink:href="#like-outline"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title card-title--campaign">
                                        SDT Lab One
                                    </h5>

                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>

                                    <div class="card-progress">
                                        <div class="row">
                                            <div class="col-6">
                                                <p>Zebrane (50%):</p>
                                                <p class="fs-6"><strong>167 tys. PLN</strong></p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p>Cel:</p>
                                                <p class="fs-6">700 tys. PLN</p>
                                            </div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Basic example"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>

                                    </div>

                                    <div class="campaign-countdown">
                                        <p class="text-uppercase">
                                            <strong>Pozostało:</strong>
                                        </p>
                                        <div class="countdown" data-date="24-9-2023" data-time="23:00">
                                            <div class="day"><span class="num"></span><span class="word"> dni</span>
                                            </div>
                                            <div class="hour"><span class="num"></span><span class="word"> godzin</span>
                                            </div>
                                            <div class="min"><span class="num"></span><span class="word"> minut</span>
                                            </div>
                                            <div class="sec"><span class="num"></span><span class="word"> sekund</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>


                        </div>
                        <div class="col-lg-6">

                            <a class="card card-campaign mb-3" href="kampania.html">
                                <div class="card-main-image img-rounded-right-top">
                                    <img src="assets/images/photo1.jpg" class="card-img-top" alt="Token">
                                    <div class="card-main-image-overlay">
                                        <span>Zobacz więcej</span>
                                    </div>
                                    <div class="card-main-image-flags">
                                        <strong>2</strong> Inwestycje
                                    </div>
                                    <div class="card-main-image-like">
                                        <svg class="icon">
                                            <use xlink:href="#like-outline"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title card-title--campaign">
                                        SDT Lab One
                                    </h5>

                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>

                                    <div class="card-progress">
                                        <div class="row">
                                            <div class="col-6">
                                                <p>Zebrane (50%):</p>
                                                <p class="fs-6"><strong>167 tys. PLN</strong></p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p>Cel:</p>
                                                <p class="fs-6">700 tys. PLN</p>
                                            </div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Basic example"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>

                                    </div>

                                    <div class="campaign-countdown">
                                        <p class="text-uppercase">
                                            <strong>Pozostało:</strong>
                                        </p>
                                        <div class="countdown" data-date="24-9-2023" data-time="23:00">
                                            <div class="day"><span class="num"></span><span class="word"> dni</span>
                                            </div>
                                            <div class="hour"><span class="num"></span><span class="word"> godzin</span>
                                            </div>
                                            <div class="min"><span class="num"></span><span class="word"> minut</span>
                                            </div>
                                            <div class="sec"><span class="num"></span><span class="word"> sekund</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>


                        </div>
                        <div class="col-lg-6">

                            <a class="card card-campaign mb-3" href="kampania.html">
                                <div class="card-main-image img-rounded-right-top">
                                    <img src="assets/images/photo1.jpg" class="card-img-top" alt="Token">
                                    <div class="card-main-image-overlay">
                                        <span>Zobacz więcej</span>
                                    </div>
                                    <div class="card-main-image-flags">
                                        <strong>2</strong> Inwestycje
                                    </div>
                                    <div class="card-main-image-like">
                                        <svg class="icon">
                                            <use xlink:href="#like-outline"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title card-title--campaign">
                                        SDT Lab One
                                    </h5>

                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>

                                    <div class="card-progress">
                                        <div class="row">
                                            <div class="col-6">
                                                <p>Zebrane (50%):</p>
                                                <p class="fs-6"><strong>167 tys. PLN</strong></p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p>Cel:</p>
                                                <p class="fs-6">700 tys. PLN</p>
                                            </div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Basic example"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>

                                    </div>

                                    <div class="campaign-countdown">
                                        <p class="text-uppercase">
                                            <strong>Pozostało:</strong>
                                        </p>
                                        <div class="countdown" data-date="24-9-2023" data-time="23:00">
                                            <div class="day"><span class="num"></span><span class="word"> dni</span>
                                            </div>
                                            <div class="hour"><span class="num"></span><span class="word"> godzin</span>
                                            </div>
                                            <div class="min"><span class="num"></span><span class="word"> minut</span>
                                            </div>
                                            <div class="sec"><span class="num"></span><span class="word"> sekund</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>


                        </div>
                        <div class="col-lg-6">

                            <a class="card card-campaign mb-3" href="kampania.html">
                                <div class="card-main-image img-rounded-right-top">
                                    <img src="assets/images/photo1.jpg" class="card-img-top" alt="Token">
                                    <div class="card-main-image-overlay">
                                        <span>Zobacz więcej</span>
                                    </div>
                                    <div class="card-main-image-flags">
                                        <strong>2</strong> Inwestycje
                                    </div>
                                    <div class="card-main-image-like">
                                        <svg class="icon">
                                            <use xlink:href="#like-outline"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title card-title--campaign">
                                        SDT Lab One
                                    </h5>

                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>

                                    <div class="card-progress">
                                        <div class="row">
                                            <div class="col-6">
                                                <p>Zebrane (50%):</p>
                                                <p class="fs-6"><strong>167 tys. PLN</strong></p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <p>Cel:</p>
                                                <p class="fs-6">700 tys. PLN</p>
                                            </div>
                                        </div>
                                        <div class="progress" role="progressbar" aria-label="Basic example"
                                             aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: 50%"></div>
                                        </div>

                                    </div>

                                    <div class="campaign-countdown">
                                        <p class="text-uppercase">
                                            <strong>Pozostało:</strong>
                                        </p>
                                        <div class="countdown" data-date="24-9-2023" data-time="23:00">
                                            <div class="day"><span class="num"></span><span class="word"> dni</span>
                                            </div>
                                            <div class="hour"><span class="num"></span><span class="word"> godzin</span>
                                            </div>
                                            <div class="min"><span class="num"></span><span class="word"> minut</span>
                                            </div>
                                            <div class="sec"><span class="num"></span><span class="word"> sekund</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>


                        </div>
                    </div>

                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item prev"><a class="page-link" href="#">
                                    <svg class="icon">
                                        <use xlink:href="#long-left-arrow"/>
                                    </svg>
                                </a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><span class="page-link" href="#">...</span></li>
                            <li class="page-item"><a class="page-link" href="#">10</a></li>
                            <li class="page-item next"><a class="page-link" href="#">
                                    <svg class="icon">
                                        <use xlink:href="#long-right-arrow"/>
                                    </svg>
                                </a></li>
                        </ul>
                    </nav>


                </div>


            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 ms-lg-auto">
                <div class="account-main-block">

                    <div class="bg-green-right">
                        <div class="bg-green-right-content">
                            <div class="row">
                                <div class="col-lg-8 mx-auto">
                                    <h3 class="fw-light font-museo mb-5 text-uppercase">
                                        Szukasz finansowania?
                                    </h3>

                                    <p class="mb-4">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.
                                    </p>

                                    <a href="#">
                                        <svg class="icon icon-long-arrow">
                                            <use xlink:href="#long-right-arrow"/>
                                        </svg>
                                    </a>

                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
