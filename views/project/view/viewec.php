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


?>

<div class="projects-info pb-5">
    <div class="container">

        <div class="row gx-lg-6 gy-5">
            <div class="col-lg-9">
                <?= $model->text ?>
            </div>
            <div class="col-lg-3">

                <div class="project-sticky">

                    <aside class="project-nav">
                        <h4>Przejdź do:</h4>
						
                        <div class="row gy-4">
                                <a href="#" class="project-btn d-block">
                                    MÓJ PORTFEL ECM
                                </a>
						</div><br>
						
						<div class="row gy-4">
                                <a href="#" class="project-btn d-block">
                                    ECM STORE
                                </a>
						</div><br>
						
						<div class="row gy-4">
                                <a href="#" class="project-btn d-block">
                                    ECM KANTOR
                                </a>
						</div>
                    </aside>

                </div>
            </div>

        </div>

    </div>
</div>
