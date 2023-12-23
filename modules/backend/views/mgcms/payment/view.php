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
        <div class="col-sm-8">
            <h2><?= Yii::t('app', 'Payment') . ' ' . Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
            <div class="hidden">
                <?=
                Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . Yii::t('app', 'PDF'),
                    ['pdf', 'id' => $model->id],
                    [
                        'class' => 'btn btn-danger',
                        'target' => '_blank',
                        'data-toggle' => 'tooltip',
                        'title' => Yii::t('app', 'Will open the generated PDF file in a new window')
                    ]
                ) ?>


                <? $controller = Yii::$app->controller->id;
                if (\app\components\mgcms\MgHelpers::getUserModel()->checkAccess($controller, 'save-as-new')):?>
                    <?= Html::a(Yii::t('app', 'Save As New'), ['save-as-new', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
                <? endif ?>


                <? $controller = Yii::$app->controller->id;
                if (\app\components\mgcms\MgHelpers::getUserModel()->checkAccess($controller, 'update')):?>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <? endif ?>
                <? $controller = Yii::$app->controller->id;
                if (\app\components\mgcms\MgHelpers::getUserModel()->checkAccess($controller, 'delete')):?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ])
                    ?>
                <? endif ?>
            </div>
        </div>
    </div>

    <div class="row">
        <?php
        $gridColumn = [
            ['attribute' => 'id', 'visible' => false],
            'created_on',
            [
                'attribute' => 'user.username',
                'label' => Yii::t('app', 'User'),
            ],
            'amount',
//            'statusStr',
//        'percentage',
//        'is_preico:boolean',
//        'user_token',
//        'ethereum_buy_date',
//        'market',
            'typeStr',
//            'comments',
            'relLink:raw',
        ];
        echo DetailView::widget([
            'model' => $model,
            'attributes' => $gridColumn
        ]);
        ?>
    </div>
</div>
