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
        <div class="col-sm-3" style="margin-top: 15px">
<?=             
             Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . Yii::t('app', 'PDF'), 
                ['pdf', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'title' => Yii::t('app', 'Will open the generated PDF file in a new window')
                ]
            )?>
            
              <? $controller = Yii::$app->controller->id;
                if(\app\components\mgcms\MgHelpers::getUserModel()->checkAccess($controller, 'update')):?>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
              <?endif?>
              <? $controller = Yii::$app->controller->id;
              if(\app\components\mgcms\MgHelpers::getUserModel()->checkAccess($controller, 'delete')):?>
              <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                  'class' => 'btn btn-danger',
                  'data' => [
                      'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                      'method' => 'post',
                  ],
              ])
              ?>
              <?endif?>
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
            'label' => Yii::t('app', 'Category'),
        ],
        [
            'attribute' => 'user.username',
            'label' => Yii::t('app', 'User'),
        ],
        'payment_status',
        'paid_from',
        'paid_to',
        [
            'attribute' => 'thumbnail.name',
            'label' => Yii::t('app', 'Thumbnail'),
        ],
        [
            'attribute' => 'background.name',
            'label' => Yii::t('app', 'Background'),
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
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-agent']],
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Agent')),
        ],
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
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-benefit']],
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Benefit')),
        ],
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
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-job']],
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Job')),
        ],
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
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-product']],
        'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Product')),
        ],
        'columns' => $gridColumnProduct
    ]);
}
?>
    </div>
</div>