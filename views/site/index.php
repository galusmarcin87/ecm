<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;

?>


<?= $this->render('index/slider') ?>
<div class="home-decoration-1">
    <img src="/images/home-decoration-1.png" alt="" class="">
</div>
<?= $this->render('index/actualProjects') ?>
<?= $this->render('index/about') ?>
<?= $this->render('index/portfolio') ?>

<div class="home-decoration-2">
    <img src="/images/home-decoration-2.png" alt="">
</div>

<br><br><br><br>
<?= $this->render('index/section2') ?>

<?= $this->render('index/news') ?>

<div class="home-decoration-3">
    <img src="/images/home-decoration-1.png" alt="" class="">
</div>

<?= $this->render('index/faq') ?>
<?= $this->render('index/newsletterForm') ?>
<?= $this->render('index/aboutUs') ?>
<?= $this->render('index/section1') ?>


<?= $this->render('index/map') ?>
