<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Project').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        'id',
        'name',
        'status',
        'localization',
        'gps_lat',
        'gps_long',
        'lead:ntext',
        'text:ntext',
        [
                'attribute' => 'file.name',
                'label' => Yii::t('app', 'File')
            ],
        'whitepaper',
        'www',
        'money',
        'money_full',
        'investition_time',
        'percentage',
        'date_presale_start',
        'date_presale_end',
        'date_crowdsale_start',
        'date_crowdsale_end',
        'percentage_presale_bonus',
        'date_realization_profit',
        'token_value',
        'token_blockchain',
        'token_to_sale',
        'token_minimal_buy',
        'token_left',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerBonus->totalCount){
    $gridColumnBonus = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'from',
        'to',
        'value',
            ];
    echo Gridview::widget([
        'dataProvider' => $providerBonus,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(Yii::t('app', 'Bonus')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnBonus
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerPayment->totalCount){
    $gridColumnPayment = [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'created_on',
                [
                'attribute' => 'user.username',
                'label' => Yii::t('app', 'User')
            ],
        'amount',
        'status',
        'percentage',
        'is_preico',
        'user_token',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerPayment,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(Yii::t('app', 'Payment')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnPayment
    ]);
}
?>
    </div>
</div>
