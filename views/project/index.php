<?php
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\widgets\ListView;
use app\models\mgcms\db\Project;
use app\models\mgcms\db\Category;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', isset($type) ? 'Series ' . $type : 'Projects');

?>
<?= $this->render('/common/sideSocialButtons') ?>
<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text']) ?>
<?= $this->render('index/summary', ['type' => $type]) ?>

<div class="portfolio-section py-5">
    <div class="section-title text-center"><?= MgHelpers::getSettingTypeText('sdt list header 4 ' . Yii::$app->language, false, 'Portfolio klastrów energii SDT') ?></div>

    <div class="section-background">
        <div class="container">


            <?=
            ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => [
                    'class' => 'col-lg-4'
                ],
                'options' => [
                    'class' => 'row gy-5',
                ],
                'layout' => '{items}',
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_tileItem', ['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this]);
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

