<?

use app\models\mgcms\db\Project;
use yii\web\View;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model Project */

$paymentSearch = new \app\models\mgcms\db\PaymentSearch();
$paymentSearch->project_id = $model->id;
$dataProvider = $paymentSearch->search([]);
$dataProvider->pagination->pageSize = 12;

?>

<div class="row">

    <?=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => [
            'class' => 'col-lg-6'
        ],
        'options' => [
            'class' => 'row gy-4 py-5',
        ],
        'layout' => '{items}',
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_investment', ['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this]);
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
