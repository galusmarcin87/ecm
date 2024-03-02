<?

/* @var $this View */

use yii\web\View;
use \app\models\mgcms\db\Category;
use yii\widgets\ListView;

?>

<div class="text-center">
    <div class="pagination">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{pager}',
            'pager' => [
//                                'firstPageLabel' => '&laquo;',
//                                'lastPageLabel' => '&raquo;',
                'prevPageLabel' => '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                'nextPageLabel' => '<i class="fa fa-arrow-right" aria-hidden="true"></i>',


                // Customzing CSS class for pager link
                'linkOptions' => [
                    'class' => 'pagination__item',
                ],
                'activePageCssClass' => 'active',
                'pageCssClass' => 'page',
                // Customzing CSS class for navigating link
                'prevPageCssClass' => 'prev',
                'nextPageCssClass' => 'next',
                'firstPageCssClass' => 'first',
                'lastPageCssClass' => 'last',
            ],
        ])


        ?>
    </div>
</div>
