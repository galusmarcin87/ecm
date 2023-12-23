<?php
/* @var $this yii\web\View */

/* @var $model \app\models\mgcms\db\Project */


use yii\helpers\Html;
use app\components\mgcms\MgHelpers;


$model->language = Yii::$app->language;

?>

<div class="item">
    <div
            class="Slider__item"
            style="background-image: url('<?= $model->file && $model->file->isImage() ? $model->file->getImageSrc(1920, 760) : '' ?>')"
    >

    </div>
</div>