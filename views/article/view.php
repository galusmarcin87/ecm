<?php

use yii\web\View;

/* @var $this yii\web\View */
//standardowy artykuł - detal

/* @var $model \app\models\mgcms\db\Article */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

?>
<?= $this->render('/common/sideSocialButtons') ?>
<?= $this->render('/common/breadcrumps', ['displayBg' => false, 'cssClass' => 'page-header-text']) ?>

<div class="post-single media-single">

    <? if ($model->file && $model->file->isImage()): ?>
        <div class="post-single-image">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-10 mx-auto">
                        <div class="img-corner-left-top">
                            <img src="<?= $model->file->getImageSrc(1200, 0) ?>" class="card-img-top" alt="Token">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? endif; ?>

    <div class="post-single-content">

        <div class="container">
            <div class="row gy-5">

                <div class="col-lg-10 mx-auto">


                    <? if ($model->type == \app\models\mgcms\db\Article::TYPE_NEWS): ?>
                        <div class="post-single-date media-single-date">
                            <?= $model->created_on ?>
                        </div>
                    <? endif; ?>
                    <?= $model->content ?>
                </div>
                </a>
            </div>
        </div>

    </div>


</div>
