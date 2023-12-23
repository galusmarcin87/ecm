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

<div class="single-campaign">

    <div class="container">
        <div class="row gy-3 gx-5">
            <? if ($model->file && $model->file->isImage()): ?>
                <div class="col-lg-6">
                    <img src="<?= $model->file->getImageSrc(624, 416) ?>" class="img-fluid img-rounded-right-top"
                         alt="<?= $model ?>">
                </div>
            <? endif; ?>
            <div class="col-lg-6 d-flex">

                <div class="campaign-info">

                    <div class="campaign-buttons">
                        <span class="btn btn-success btn-invest-count">
                            <span><?= count($model->payments) ?></span> <?= Yii::t('db', 'investitions') ?>
                        </span>
                        <a href="#" class="btn btn-blue btn-like hidden">
                            <svg class="icon">
                                <use xlink:href="#like-outline"/>
                            </svg>
                        </a>
                    </div>


                    <?= $this->render('view/progress', ['model' => $model]) ?>
                    <?= $this->render('_counterTimer', ['model' => $model]) ?>


                    <div class="campaign-actions">
                        <div class="row gy-4 align-items-center mt-auto">
                            <div class="col-md-6 text-center text-md-start">
                                <?= $this->render('view/socialShares', ['model' => $model]) ?>

                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <a href="<?= Url::to(['/project/buy', 'id' => $model->id]) ?>"
                                   class="btn-primary"><?= Yii::t('db', 'Invest') ?></a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?= $this->render('view/bonuses', ['model' => $model]) ?>


    <div class="container">

        <?= $model->text ?>
    </div>

</div>


<div class="container">
    <?= $this->render('view/tabs', ['model' => $model]) ?>

    <!-- Tab panes -->
    <div class="tab-content">

        <div class="tab-pane " id="about" role="tabpanel" aria-labelledby="about-tab" tabindex="0">
            <?= $model->text2 ?>
        </div>

        <div class="tab-pane " id="board" role="tabpanel" aria-labelledby="board-tab" tabindex="0">
            <div class="my-5">
                <h3><?= Yii::t('db', 'Management') ?></h3>
            </div>

            <?= $model->management ?>
        </div>

        <div class="tab-pane " id="investments" role="tabpanel" aria-labelledby="investments-tab" tabindex="0">
            <?= $this->render('view/investments', ['model' => $model]) ?>
        </div>

        <div class="tab-pane " id="downloads" role="tabpanel" aria-labelledby="downloads-tab" tabindex="0">
            <div class="py-5">
                <?= $this->render('view/downloads', ['model' => $model]) ?>
            </div>
        </div>

        <div class="tab-pane " id="risks" role="tabpanel" aria-labelledby="risks-tab" tabindex="0">
            <div class="py-5">
                <h3><?= Yii::t('db', 'Significant risk factors') ?></h3>
            </div>

            <?= $model->risks ?>
        </div>

        <div class="tab-pane active" id="faq" role="tabpanel" aria-labelledby="faq-tab" tabindex="0">
            <div class="py-5">
                <?= $this->render('view/faq', ['model' => $model]) ?>


            </div>
        </div>


    </div>

</div>


