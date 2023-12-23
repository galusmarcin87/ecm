<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Article').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'title',
        'content:ntext',
        'slug',
        'excerpt:ntext',
        'language',
        'created_on',
        'updated_on',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
                [
                'attribute' => 'category.name',
                'label' => Yii::t('app', 'Category')
            ],
        [
                'attribute' => 'file.name',
                'label' => Yii::t('app', 'File')
            ],
        'order',
        'promoted',
        'custom:ntext',
        'type',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
    
    <div class="row">
<?php
if($providerArticle->totalCount){
    $gridColumnArticle = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        'title',
        'content:ntext',
        'slug',
        'excerpt:ntext',
        'language',
        'created_on',
        'updated_on',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',
                [
                'attribute' => 'category.name',
                'label' => Yii::t('app', 'Category')
            ],
        [
                'attribute' => 'file.name',
                'label' => Yii::t('app', 'File')
            ],
        'order',
        'promoted',
        'custom:ntext',
        'type',
    ];
    echo Gridview::widget([
        'dataProvider' => $providerArticle,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode(Yii::t('app', 'Article')),
        ],
        'panelHeadingTemplate' => '<h4>{heading}</h4>{summary}',
        'toggleData' => false,
        'columns' => $gridColumnArticle
    ]);
}
?>
    </div>
</div>
