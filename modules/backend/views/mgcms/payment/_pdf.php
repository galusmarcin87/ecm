<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Payment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Payment').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'created_on',
        [
                'attribute' => 'project.name',
                'label' => Yii::t('app', 'Project')
            ],
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
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
