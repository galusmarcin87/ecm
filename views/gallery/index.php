<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\widgets\ListView;

$this->title = Yii::t('db', 'Galleries');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){ 
    $('.search-form').toggle(1000); 
    return false; 
});";
$this->registerJs($search);

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
                        <li class="breadcrumb-item"><a href="#">
                                <svg class="icon">
                                    <use xlink:href="#home"/>
                                </svg>
                            </a></li>

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

<div class="article-index"> 

    <h1><?= Html::encode($this->title) ?></h1> 

    <div class="row">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
              return $this->render('_index', ['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this]);
            },
        ])

        ?> 
    </div>

</div> 