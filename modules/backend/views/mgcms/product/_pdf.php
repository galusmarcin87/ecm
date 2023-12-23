<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Product').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
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
        [
                'attribute' => 'company.name',
                'label' => Yii::t('app', 'Company')
            ],
        [
                'attribute' => 'file.name',
                'label' => Yii::t('app', 'File')
            ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
