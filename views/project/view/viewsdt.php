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
            <div class="col-lg-8">


                <?= $this->render('slider', ['model' => $model]) ?>

                <?= $this->render('table', ['model' => $model]) ?>

                <? // $this->render('socialShares', ['model' => $model]) ?>


                <?= $model->text ?>

                <?= $this->render('roadmap', ['model' => $model]) ?>

            </div>
            <div class="col-lg-4">

                <div class="project-sticky">

                    <a href="<?= Url::to(['project/buy', 'id' => $model->id]) ?>" class="btn btn-dark d-block btn-lg">
                        <?= Yii::t('db', 'Invest') ?>
                    </a>


                    <?= $this->render('details', ['model' => $model]) ?>

                    <?= $this->render('downloads', ['model' => $model]) ?>



                </div>
            </div>

        </div>

    </div>
</div>
