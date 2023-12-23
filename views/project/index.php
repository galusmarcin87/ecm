<?php
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\widgets\ListView;
use app\models\mgcms\db\Project;
use app\models\mgcms\db\Category;

$this->title = Yii::t('db', 'Campaigns');

?>

<?= $this->render('/common/breadcrumps') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <?= \app\components\mgcms\MgHelpers::getSettingTypeText('projects - text ' . Yii::$app->language, true, ' <p>
                Z Opal Crowd masz możliwość inwestowania w spółki do tej pory zarezerwowane dla nielicznych.<br/>
                Dołącz do grona profesjonalistów i zdobądź możliwość osiągnięcia ponadprzeciętnych zysków, dzięki
                korzyściom jakie oferuje platforma CrowdFoundingu udziałowego z Opal Crowd
            </p>') ?>

        </div>
    </div>


    <div class="campaigns">

        <div class="filters">
            <div class="filters-label">
                <?= Yii::t('db', 'Choose filter') ?>:
            </div>
            <div class="filters-items">
                <a href="<?= \yii\helpers\Url::to(['project/index', 'status' => Project::STATUS_ACTIVE]) ?>"
                   class="filters-items-item <?= $status == Project::STATUS_ACTIVE ? 'active' : '' ?> js-filter"><?= Yii::t('db', 'Active') ?></a>
                <a href="<?= \yii\helpers\Url::to(['project/index', 'status' => Project::STATUS_PLANNED]) ?>"
                   class="filters-items-item <?= $status == Project::STATUS_PLANNED ? 'active' : '' ?> js-filter"><?= Yii::t('db', 'Upcoming') ?></a>
                <a href="<?= \yii\helpers\Url::to(['project/index', 'status' => Project::STATUS_ENDED]) ?>"
                   class="filters-items-item <?= $status == Project::STATUS_ENDED ? 'active' : '' ?> js-filter"><?= Yii::t('db', 'Ended') ?></a>
            </div>
        </div>

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

