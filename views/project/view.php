<?php
/* @var $model app\models\mgcms\db\Project */
/* @var $form app\components\mgcms\yii\ActiveForm */

/* @var $this yii\web\View */

/* @var $subscribeForm \app\models\SubscribeForm */

use app\components\mgcms\MgHelpers;
use yii\web\View;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use  \app\models\mgcms\db\Project;


$this->title = $model->name;
$model->language = Yii::$app->language;


$this->params['breadcrumbs'][] = [\yii\helpers\Url::to('/project/index'), Yii::t('db', 'Campaigns')];
?>

<?= $this->render('/common/breadcrumps') ?>

<div class="projects-info pb-5">
    <div class="container">

        <div class="row gx-lg-6 gy-5">
            <div class="col-lg-8">

                <div class="project-map">
                    <div id="googlemap" style="height:565px" data-lat="52.2296756" data-lng="21.0122287"></div>
                    <div class="map-points">
                        <div class="map-point" data-lat="52.2296756" data-lng="21.0122287" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. "></div>
                        <div class="map-point" data-lat="48.856614" data-lng="2.3522219" data-description="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. "></div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6">

                    <dl>
                        <dt>Wartość:</dt>
                        <dd><?= $model->money_full ?> $</dd>

                        <dt>Start pre-sale:</dt>
                        <dd><?= $model->date_presale_start ?></dd>

                        <dt>Koniec pre-sale:</dt>
                        <dd><?= $model->date_presale_end ?></dd>

                        <dt>Start crowdsale:</dt>
                        <dd><?= $model->date_crowdsale_start ?></dd>
                    </dl>              

                </div>
                <div class="col-lg-6">
                    <dl>
                        <dt>Koniec crowdsale:</dt>
                        <dd><?= $model->date_crowdsale_end ?></dd>
						
						<dt>Zysk presale:</dt>
                        <dd><?= $model->percentage_presale_bonus ?></dd>

                        <dt>Zysk crowdsale:</dt>
                        <dd><?= $model->percentage ?></dd>

                        <dt>Minimal buy:</dt>
                        <dd><?= $model->token_minimal_buy ?></dd>
                    </dl>
                </div>
                </div>

                <h2>
                    O projekcie
                </h2>
                <p>
                    <?= $model->lead ?>
                </p>

                <h2>
                   Koncepcja
                </h2>
                <p>
                   <?= $model->text ?>
                </p>

                <div class="roadmap-slider">

    

    <h2 class="text-uppercase fw-bold font-oswald">Roadmap</h2>

    <div class="swiper project-roadmap-carousel">
    <div class="swiper-wrapper">
      
                        
                        <div class="swiper-slide col-md-5">
                            <div class="roadmap-item">
                                <h3>od IV 2022</h3>
                                <p>Etap I - Budowa Public Relations</p>
                            </div>
                        </div>
                        
                        <div class="swiper-slide col-md-5">
                            <div class="roadmap-item">
                                <h3>IV 2022 - III 2023</h3>
                                <p>Przygotowanie programu SDT1<br /> Future Solutions LAB ONE</p>
                            </div>
                        </div>
                        
                        <div class="swiper-slide col-md-5">
                            <div class="roadmap-item">
                                <h3>od IV 2023</h3>
                                <p>Tokenizacja (ITO)</p>
                            </div>
                        </div>
                        
                    </div>
      
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
    </div>
</div>





                <h2>
                    Technologia
                </h2>
                <p>
                    <?= $model->text2 ?>
                </p>


                
            </div>
            <div class="col-lg-4">

                <div class="project-sticky">


                    <a href="<?= Url::to(['project/buy', 'id' => $model->id]) ?>" class="btn btn-dark d-block btn-lg"><?= Yii::t('db', 'INVEST') ?></a>

                
                <aside class="project-details">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="project-icons">
                                <div class="project-icons-icon">
                                    <svg class="icon">
                                        <use xlink:href="#calendar" />
                                    </svg>
                                </div>
                                <div class="project-icons-text">
                                    <?= $model->investition_time ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="project-icons">
                                <div class="project-icons-icon">
                                    <svg class="icon">
                                        <use xlink:href="#procent" />
                                    </svg>
                                </div>
                                <div class="project-icons-text">
                                    <?= $model->percentage ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <div class="project-countdown">
                        <p class="text-uppercase">
                            <strong>Pozostało:</strong>
                        </p>
                        <div class="countdown" data-date="24-9-2023"  data-time="23:00">
                            <div class="day"><span class="num"></span><span class="word"> dni</span></div>
                            <div class="hour"><span class="num"></span><span class="word"> godzin</span></div>
                            <div class="min"><span class="num"></span><span class="word"> minut</span></div>
                            <div class="sec"><span class="num"></span><span class="word"> sekund</span></div>
                        </div>
                    </div>


                    <div class="project-progress">
								<?= $this->render('view/progress', ['model' => $model]) ?>
                    </div>

                </aside>


                <aside class="project-nav">
                    <h4>Zobacz:</h4>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <a href="#" class="project-btn d-block">
                                White paper ECM
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="project-btn d-block">
                                ECM pigułka
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="project-btn d-block">
                                Regulamin
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="project-btn d-block">
                                Polityka prywatności
                            </a>
                        </div>
                    </div>
                </aside>

                
            </div>

            </div>
            
        </div>

    </div>
</div>