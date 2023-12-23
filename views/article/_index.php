<?php

use \yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Article */
$displayImageHook = isset($displayImageHook) ? $displayImageHook : false;
?>

<?if($index == 2 && $displayImageHook):?>
<div class="news decoration">
    <img src="/images/home-news.png" alt="" class="img-fluid">
</div>
</div>
<div class="col-lg-4">

<?endif;?>

<a class="card card-light mb-3" href="<?= $model->linkUrl ?>">
    <div class="card-body">

        <h5 class="card-title card-title--news">
            <?= $model->title ?>
        </h5>
        <div class="card-date">
            <?= $model->created_on ?>
        </div>
        <?= $model->excerpt ?>
        <span class="card-readmore"><?= Yii::t('db', 'Find out more') ?></span>
    </div>
</a>
