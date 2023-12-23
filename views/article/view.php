<?php

use yii\web\View;

/* @var $this yii\web\View */
//standardowy artykuł - detal
/* @var $model \app\models\mgcms\db\Article */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

?>

<div class="page-header " style="background-image:url(/images/page-header.jpg);">
    <div class="page-header-content">
    <div class="container">
        <h1 class="page-header-title">
            <?= $this->title ?>
        </h1>

        <div class="breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					

					<? if (isset($this->params['breadcrumbs'])): ?>
					<? foreach ($this->params['breadcrumbs'] as $item): ?>
					<? if (is_array($item)) : ?>
					<li class="breadcrumb-item"><a href="<?= $item[0] ?>"><?= $item[1] ?></a></li>
					<? else: ?>
					<li class="breadcrumb-item"><?= $item ?></li>
					<? endif; ?>
					<? endforeach; ?>
					<? endif; ?>
					<li class="breadcrumb-item active" aria-current="page"><?= $this->title ?></li>
				</ol>
            </nav>
        </div>        
    </div>
	</div>
</div>

<div class="post-single media-single">
    <div class="post-single-image">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-10 mx-auto">
                    <div class="img-corner-left-top" style="max-width: 1000px; margin: auto;">
                        <? foreach ($model->files as $file): ?>
                        <? if (!$file->isImage()) continue; ?>
                        <a class="Gallery__card" href="<?= $file->imageSrc ?>">
                            <img
                                 class="Gallery__image fadeIn animated"
                                 src="<?= $file->imageSrc ?>"
                                 alt=""
                                 style="width: 100%; height: auto;"
                                 />
                        </a>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="post-single-content">
    <div class="container">
        <div class="row gy-5">
            <?= $model->content ?>
        </div>
    </div>
</div>
