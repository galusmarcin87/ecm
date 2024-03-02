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

<div class="home-decoration-2">
    <img src="/images/home-decoration-3.png" alt="">
</div>
<br><br>
<?= $this->render('index/portfolio') ?>
<?= $this->render('index/section1') ?>
<?= $this->render('index/section2') ?>
<?= $this->render('/common/newsletterForm') ?>

<div class="home-decoration-3" style="position: relative; top: 100px;">
    <img src="/images/home-decoration-1.png" alt="" class="">
</div>

<?= $this->render('index/news') ?>
<?= $this->render('/common/map') ?>
