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
        <div class="col-sm-8">
            <h2><?= Yii::t('app', 'Project') . ' ' . Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-4" style="margin-top: 15px">
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

    <div class="row">
        <?php
        $gridColumn = [
            'id',
            'name',
	        'status',
	        'lead:raw',
	        'file_id',
	        'money_full',
	        'money',
	        'token_value',
	        'token_minimal_buy',
	        'date_crowdsale_start',
	        'date_crowdsale_end',
	        'created_by',
	        'lead',
	        'text',
	        'text2',
	        'management',
	        'risks',
	        'fiber_collect_id',
	        'iban',
	        'pay_name',
	        'pay_description',
	        'Images',
        	'Files to download',
	
 //           [
 //               'attribute' => 'emails',
 //               'value' => function($model) {
 //                   return $model->getModelAttribute('emails');
 //               },
 //               'format' => 'raw'
 //           ],
       ];
       echo DetailView::widget([
           'model' => $model,
           'attributes' => $gridColumn
       ]);
        ?>
    </div>

    <div class="row">
        <?php
        if ($providerBonus->totalCount) {
            $gridColumnBonus = [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'from',
                'to',
                'value',
            ];
            echo Gridview::widget([
                'dataProvider' => $providerBonus,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-bonus']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Lista cech')),
                ],
                'columns' => $gridColumnBonus
            ]);
        }
        ?>
    </div>
	
	    <div class="row">
        <?php
        if ($providerBonus->totalCount) {
            $gridColumnBonus = [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'from',
                'to',
                'value',
            ];
            echo Gridview::widget([
                'dataProvider' => $providerBonus,
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-bonus']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'FAQ')),
                ],
                'columns' => $gridColumnBonus
            ]);
        }
        ?>
    </div>
	
    <div class="row">
        <?php
        if ($providerPayment->totalCount) {
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
                'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-payment']],
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<span class="glyphicon glyphicon-book"></span> ' . Html::encode(Yii::t('app', 'Payment')),
                ],
                'columns' => $gridColumnPayment
            ]);
        }
        ?>
    </div>
</div>
