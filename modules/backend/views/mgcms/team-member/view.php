<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\TeamMember */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-member-view">

    <div class="row">
        <div class="col-sm-8">
            <h2><?= Yii::t('app', 'Team Member').' '. Html::encode($this->title) ?></h2>
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
            )?>
<? $controller = Yii::$app->controller->id;
        if(\app\components\mgcms\MgHelpers::getUserModel()->checkAccess($controller, 'save-as-new')):?>   
        <?= Html::a(Yii::t('app', 'Save As New'), ['save-as-new', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    <?endif?>          
          
            
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
        'surname',
        'is_team:boolean',
        'is_consultant:boolean',
        'phone',
        'description',
        'file:raw',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>