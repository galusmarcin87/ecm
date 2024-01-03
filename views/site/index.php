<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;

?>

<?= $this->render('index/slider') ?>
<?= $this->render('index/about') ?>

<div class="home-decoration-1">
    <img src="/images/home-decoration-1.png" alt="" class="">
</div>

<?= $this->render('index/actualProjects') ?>

<div class="home-decoration-2">
    <img src="/images/home-decoration-2.png" alt="">
</div>

<?= $this->render('index/portfolio') ?>
<?= $this->render('index/section1') ?>
<?= $this->render('index/section2') ?>
<?= $this->render('index/newsletterForm') ?>

<div class="home-decoration-3">
    <img src="/images/home-decoration-1.png" alt="" class="">
</div>

<?= $this->render('index/news') ?>
<?= $this->render('index/map') ?>
