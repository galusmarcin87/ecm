<?php
/* @var $this yii\web\View */


use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'Invest');


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

<div class="bg-lg-half-decoration py-6 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                
                <div class="pe-lg-5">

                    <form action="#">
                    <h4 class="font-oswald fw-bold mb-6">Wprowadź kwotę inwestycji</h4>
                    
                    <div class="mb-6">
                        <input type="text" class="form-control" name="value" placeholder="10000" />
                    </div>

                    <button class="btn btn-primary btn-wide" type="submit">Przelicz</button>

                    </form>

                </div>

            </div>
            <div class="col-lg-6">

                <div class="ps-lg-5">
                    <h4 class="font-oswald fw-bold mb-6">
                        Wartość w BNB
                    </h4>
                    <p class="fw-bold bnb-value" id="bnb-value">343784,98</p>
                </div>

            </div>

        </div>
    </div>
</div>
