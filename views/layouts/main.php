<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use app\widgets\AdWidget;
use yii\helpers\Html;

//use app\assets\AppAsset;
use app\assets\FrontAsset;
use app\components\mgcms\MgHelpers;

//AppAsset::register($this);
FrontAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#212121" media="(prefers-color-scheme: dark)">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>


</head>
<body id="page_<?= Yii::$app->controller->id . '_' . Yii::$app->controller->action->id ?>">
<?php $this->beginBody() ?>
<?= $this->render('header') ?>
<?= Alert::widget() ?>
<?= AdWidget::widget() ?>
<?= $content ?>
<?= $this->render('footer') ?>
<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
