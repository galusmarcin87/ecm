<?php
/* @var $this yii\web\View */

/* @var $user \app\models\mgcms\db\User */


use yii\base\BaseObject;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Payment;
use kartik\grid\GridView;

$searchModel = new \app\models\mgcms\db\PaymentSearch();
$searchParams = ['PaymentSearch' => ['user_id' => $user->id]];
$dataProvider = $searchModel->search($searchParams);


?>
<style>
    .red {
        color: #dc0211;
    }

    .green {
        color: #069844;
    }
</style>

<div class="payment-grid">
    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        'project.name',
        'project.link:raw',
        [
            'attribute' => 'amount',
            'label' => Yii::t('db', 'My investition'),
            'format' => 'numberSeparatedWithSpace'
        ],
        'statusToDisplay:raw',
        [
            'attribute' => 'created_on',
            'label' => Yii::t('db', 'Payment date')
        ],
        'project.investition_time',
        'project.daysLeft',
        'benefitWithAmount:numberSeparatedWithSpace',
        [
            'label' => Yii::t('db', 'Increse investition'),
            'value' => function ($model, $key, $index, $column) {
                return Html::a(Yii::t('db', 'invest'), ['project/buy', 'id' => $model->project->id]);
            },
            'format' => 'raw'
        ],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('account/_detail', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,
            'expandIcon' => '<span class="arrowDown"></span>',
            'collapseIcon' => '<span class="arrowUp"></span>',
        ],


    ];

    ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-payment']],
        'summary' => false,
        'bordered' => false,
        'options' => ['class' => 'mainTable']
        // your toolbar can include the additional full export menu
    ]);

    ?>

</div>

<script>
  $('.mainTable > div.table-responsive > table > tbody > tr').each(function (index) {
    $(this).addClass(index % 2 ? 'even' : 'odd');
  });
</script>
