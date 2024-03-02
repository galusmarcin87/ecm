<?php
/* @var $this yii\web\View */
// Aktualnosci lista

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\widgets\ListView;

$this->title = Yii::t('db', 'News');
if (isset($tag) && $tag) {
    $this->title = Yii::t('db', 'Tag') . ' - ' . $tag;
}


?>
<?= $this->render('/common/sideSocialButtons') ?>
<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text']) ?>

<div class="posts-section py-5 my-5">

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
                    return $this->render('_index', ['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this,'cssClass' => 'card-light']);
                },
            ])

            ?>


            <nav aria-label="Page navigation">
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
            </nav>


        </div>
    </div>
</div>


