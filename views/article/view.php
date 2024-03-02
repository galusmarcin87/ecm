<?php

use yii\web\View;

/* @var $this yii\web\View */
//standardowy artykuł - detal

/* @var $model \app\models\mgcms\db\Article */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

$bg = false;
foreach ($model->files as $file) {
    if($file->isImage()){
        $bg = $file->getImageSrc();
        //break loop on first image
        break;
    }
}

?>
<?= $this->render('/common/sideSocialButtons') ?>
<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text','backgroundImage' => $bg]) ?>

<div class="post-single media-single">

    <? if ($model->file && $model->file->isImage()): ?>
        <div class="post-single-image">
            <div class="container">
                <div class="row gy-5">
                    <div class="col-lg-12 mx-auto">
                        <div class="img-corner-left-top">
                            <img src="<?= $model->file->getImageSrc(1200, 0) ?>" class="card-img-top" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? endif; ?>

    <div class="post-single-content">

        <div class="container">
            <div class="row gy-5">

                <div class="col-lg-12 mx-auto">


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
