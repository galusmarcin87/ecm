<?php
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

$dataProvider = new ArrayDataProvider([
    'allModels' => $model->slides,
    'key' => 'id',
    'modelClass' => 'app\models\mgcms\db\Slide'
    ]);
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    ['attribute' => 'id', 'visible' => false],
    'name',
    'header',
    'subheader',
    'body:ntext',
    'order',
    [
        'attribute' => 'file',
        'label' => Yii::t('app', 'File'),
        'format' => 'raw'
    ],
//        [
//            'class' => app\components\mgcms\yii\ActionColumn::className(),
//            'controller' => 'slide'
//        ],
];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'containerOptions' => ['style' => 'overflow: auto'],
    'pjax' => true,
    'beforeHeader' => [
        [
            'options' => ['class' => 'skip-export']
        ]
    ],
    'export' => [
        'fontAwesome' => true
    ],
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' => true,
    'hover' => true,
    'showPageSummary' => false,
    'persistResize' => false,
]);
