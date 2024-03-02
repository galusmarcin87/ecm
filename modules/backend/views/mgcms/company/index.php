<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\mgcms\db\CompanySearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use app\components\mgcms\MgHelpers;


$this->title = Yii::t('app', 'Company');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(500);
	return false;
});";
$this->registerJs($search);

$currentUserId = Yii::$app->getRequest()->getQueryParam('CompanySearch')? Yii::$app->getRequest()->getQueryParam('CompanySearch')['created_by'] : false;


?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <? $controller = Yii::$app->controller->id;
        if (\app\components\mgcms\MgHelpers::getUserModel()->checkAccess($controller, 'create')):?>
            <?= Html::a(Yii::t('app', 'Create Company'), ['create'], ['class' => 'btn btn-success']) ?>
        <? endif ?>
        <?= Html::a(Yii::t('app', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']) ?>
    </p>
    <div class="search-form" style="<?= $currentUserId ? '': 'display:none'?>">

    </div>
    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'class' => app\components\mgcms\yii\ActionColumn::className(),
        ],
        'name',
        'is_promoted:boolean',
        [
            'attribute' => 'status',
            'value' => function ($model) {
                return in_array($model->status,\app\models\mgcms\db\Company::STATUSES) ? \app\models\mgcms\db\Company::STATUSES[$model->status]: '';
            },
            'format' => 'translate',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \app\models\mgcms\db\Company::STATUSES,
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => Yii::t('app', 'Status')]
        ],
        [
            'attribute' => 'country',
            'value' => function ($model) {
                return Yii::t('db', $model->country);
            },
            'format' => 'translate',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => MgHelpers::getSettingOptionArrayTranslated('countries array'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => Yii::t('app', 'Status')]
        ],
        'city',
        'phone',
        'email:email',
        'created_on',
        [
            'attribute' => 'created_by',
            'label' => Yii::t('app', 'Created By'),
            'value' => function ($model) {
                return $model->createdBy;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\User::find()->all(), 'id', 'toString'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => Yii::t('db','User'), 'id' => 'grid-company-search-category_id']
        ],
        [
            'attribute' => 'category_id',
            'label' => Yii::t('app', 'Category'),
            'value' => function ($model) {
                return $model->category ? $model->category->name : '';
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Category::find()->where(['type' => \app\models\mgcms\db\Category::TYPE_COMPANY_TYPE])->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Category', 'id' => 'grid-company-search-category_id']
        ],


    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-company']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        // your toolbar can include the additional full export menu
        'toolbar' => [
            '{export}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumn,
                'target' => ExportMenu::TARGET_BLANK,
                'fontAwesome' => true,
                'dropdownOptions' => [
                    'label' => 'Full',
                    'class' => 'btn btn-default',
                    'itemsBefore' => [
                        '<li class="dropdown-header">Export All Data</li>',
                    ],
                ],
            ]),
        ],
    ]); ?>

</div>
