<?php

use \yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Article */
$model->language = Yii::$app->language;
$cssClass = isset($cssClass) ? $cssClass : 'card-dark';
?>

<a class="card <?= $cssClass ?> mb-3" href="<?= $model->linkUrl ?>">
    <div class="card-main-image img-corner-<?= $cssClass === 'card-dark' ? 'left' : 'right' ?>-top">
        <? if ($model->file && $model->file->isImage()): ?>
            <img src="<?= $model->file->getImageSrc(450, 271); ?>" class="card-img-top" alt="<?= $model ?>"/>
        <? endif; ?>
        <img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
        <div class="card-main-image-overlay">
            <span class="btn">Poznaj szczegóły</span>
        </div>
    </div>
    <div class="card-body">
        <div class="card-date">
            <?= $model->created_on ?>
        </div>
        <h5 class="card-title--news">
            <?= $model->title ?>
        </h5>
        <?= $model->excerpt ?>
        <span class="card-readmore"><?= Yii::t('db', 'Read more') ?></span>
    </div>
</a>

