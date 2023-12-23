<?

use app\widgets\NobleMenu;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use yii\bootstrap\ActiveForm;

$menu = new NobleMenu(['name' => 'footer_' . Yii::$app->language, 'loginLink' => false]);

$facebook = MgHelpers::getSettingTypeText('footer facebook');
$linkedin = MgHelpers::getSettingTypeText('footer linkedin');
$instagram = MgHelpers::getSettingTypeText('footer instagram');

?>

    <footer class="site-footer">
    <svg class="site-footer-decoration">
        <use xlink:href="#hexagon" />
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
                    


                    <li class="nav-item">
                        <a href="#" class="nav-link">O nas</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Jak zainwestować</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Logowanie</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">FAQ</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Projekty</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Zespół</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Rejestracja</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Kariera</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Media o nas</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Partnerzy</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Regulamin</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Multimedia</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Kontakt</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Instrukcje</a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link">Polityka prywatności</a>
                    </li>

                </ul>
            </div>
        </div>
        </div>
        <div class="footer-lines">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="d-flex flex-column flex-lg-row align-items-center">
                    <a href="mailto:office@ecmarket.eu" class="footer-mail">
                        <div class="footer-mail-icon">
                            <svg class="icon">
                                <use xlink:href="#envelope" />
                            </svg>
                        </div>
                        <div class="footer-mail-text">
                            office@ecmarket.eu
                        </div>
                    </a>
                    <a href="mailto:office@ecmarket.eu" class="footer-mail">
                        <div class="footer-mail-icon">
                            <svg class="icon">
                                <use xlink:href="#envelope" />
                            </svg>
                        </div>
                        <div class="footer-mail-text">
                            ecminwestors@ecmarket.eu
                        </div>
                    </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-end d-flex">
                    <ul class="nav nav-social mx-auto me-lg-0 ms-lg-auto">
                                            


                    <li class="nav-item">
                        <a href="#" class="nav-link"><svg class="icon"><use xlink:href="#reddit" /></svg></a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link"><svg class="icon"><use xlink:href="#instagram" /></svg></a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link"><svg class="icon"><use xlink:href="#youtube" /></svg></a>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link"><svg class="icon"><use xlink:href="#facebook" /></svg></a>
                    </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="site-info">
            <div class="row">
                <div class="col-lg-6">
                    &copy; 2023 Energy Coin Market Sp. z o.o.
                </div>
                <div class="col-lg-6 text-lg-end">
                    Realizacja i projekt: <a href="https://vertesdesign.pl/">Vertes Design</a>
                </div>
            </div>
        </div>
    </div>
    </div>
</footer>
