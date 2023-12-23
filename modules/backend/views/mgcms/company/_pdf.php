<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Company'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Company').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'description:ntext',
        'is_promoted',
        'first_name',
        'surname',
        'status',
        'country',
        'city',
        'postcode',
        'street',
        'phone',
        'email:email',
        'www',
        'nip',
        'regon',
        'krs',
        'banc_account_no',
        'gps_lat',
        'gps_long',
        'subscription_fee',
        'companycol',
        'created_on',
        [
                'attribute' => 'category.name',
                'label' => Yii::t('app', 'Category')
            ],
        [
                'attribute' => 'user.username',
                'label' => Yii::t('app', 'User')
            ],
        'payment_status',
        'paid_from',
        'paid_to',
        [
                'attribute' => 'thumbnail.name',
                'label' => Yii::t('app', 'Thumbnail')
            ],
        [
                'attribute' => 'background.name',
                'label' => Yii::t('app', 'Background')
            ],
        'is_for_sale',
        'sale_title',
        'sale_description:ntext',
        'sale_price',
        'sale_currency',
        'sale_price_includes:ntext',
        'sale_reason:ntext',
        'sale_business_range',
        'sale_workers_number',
        'sale_sale_range',
        'sale_last_year_income',
        'sale_company_profile',
        'is_institution',
        'institution_agent_prefix',
        'institution_invoice_amount',
        'companycol1',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerAgent->totalCount){
    $gridColumnAgent = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'full_name',
        'position',
        'description:ntext',
        'phone',
        [
                'attribute' => 'file.name',
                'label' => Yii::t('app', 'File')
            ],
        'email:email',
        'agentcol',
            ];
    echo Gridview::widget([
        'dataProvider' => $providerAgent,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(Yii::t('app', 'Agent')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnAgent
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerBenefit->totalCount){
    $gridColumnBenefit = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'name',
        'description:ntext',
        'price',
            ];
    echo Gridview::widget([
        'dataProvider' => $providerBenefit,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(Yii::t('app', 'Benefit')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnBenefit
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerJob->totalCount){
    $gridColumnJob = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'name',
                'salary',
        'position',
        'address',
        'industry',
        'info:ntext',
        'requirements:ntext',
        'country',
        'city',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerJob,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(Yii::t('app', 'Job')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnJob
    ]);
}
?>
    </div>
    
    <div class="row">
<?php
if($providerProduct->totalCount){
    $gridColumnProduct = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'name',
        'created_on',
        [
                'attribute' => 'category.name',
                'label' => Yii::t('app', 'Category')
            ],
        'description:ntext',
        'specification:ntext',
        'price',
        'number',
        'is_special_offer',
        'special_offer_from',
        'special_offer_to',
        'min_amount_of_purchase',
        'special_offer_price',
            ];
    echo Gridview::widget([
        'dataProvider' => $providerProduct,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(Yii::t('app', 'Product')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnProduct
    ]);
}
?>
    </div>
</div>
