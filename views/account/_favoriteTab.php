<?php
/* @var $this yii\web\View */

use app\models\mgcms\db\Project;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$newestCampaign = Project::find()->where(['status' => Project::STATUS_ACTIVE])->orderBy('id DESC')->one();
$query = Project::find()->joinWith('projectUsers')
    ->where([
        'status' => Project::STATUS_ACTIVE,
        'project_user.user_id' => \app\components\mgcms\MgHelpers::getUserModel()->id]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 6,
    ],
    'sort' => [
        'attributes' => [
            'order' => SORT_ASC,
        ]
    ],
]);
$this->title = Yii::t('db', 'Main panel');
?>

<?= $this->render('/common/breadcrumps') ?>

<?= $this->render('_investor') ?>
<div class="account-page">
    <div class="container">


        <div class="row gx-4">

            <?= $this->render('_leftNav', ['tab' => $tab]) ?>

            <div class="col-lg-8 account-content-col">


                <div class="account-main-block">
                    <h2 class="section-title section-title--small">
                        <?= Yii::t('db', 'Favorite') ?>
                    </h2>


                    <?=
                    ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => [
                            'class' => 'col-lg-6'
                        ],
                        'options' => [
                            'class' => 'row gy-5',
                        ],
                        'layout' => '{items}',
                        'itemView' => function ($model, $key, $index, $widget) {
                            return $this->render('/project/_tileItem', ['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this]);
                        },
                    ])

                    ?>

                    <div class="Pagination text-center">
                        <?=
                        ListView::widget([
                            'dataProvider' => $dataProvider,
                            'layout' => '{pager}',
                            'options' => [
                                'class' => 'Page navigation',
                                'tag' => 'nav'
                            ],
                            'pager' => [
                                'options' => ['class' => 'pagination justify-content-center'],
                                'firstPageLabel' => false,
                                'lastPageLabel' => false,
                                'prevPageLabel' => '<svg class="icon">
                            <use xlink:href="#long-left-arrow"></use>
                        </svg>',
                                'nextPageLabel' => '<svg class="icon">
                            <use xlink:href="#long-right-arrow"/>
                        </svg>',
                                // Customzing CSS class for pager link
                                'linkOptions' => [
                                    'class' => 'page-link'
                                ],
                                'activePageCssClass' => 'active',
                                'pageCssClass' => 'page-item',
                                // Customzing CSS class for navigating link
                                'prevPageCssClass' => 'page-item prev',
                                'nextPageCssClass' => 'page-item next',
                                'firstPageCssClass' => 'page-item first',
                                'lastPageCssClass' => 'page-item page-last',
                            ],
                        ])

                        ?>
                    </div>

                </div>


            </div>
        </div>


    </div>
</div>
