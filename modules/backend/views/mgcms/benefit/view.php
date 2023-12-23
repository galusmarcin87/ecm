<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Benefit */

$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Benefit'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="benefit-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Benefit').' '. Html::encode($this->title) ?></h2>
        </div>
        <div class="col-sm-3" style="margin-top: 15px">

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
        'price',
        [
            'attribute' => 'company.name',
            'label' => Yii::t('app', 'Company'),
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]);
?>
    </div>
</div>
