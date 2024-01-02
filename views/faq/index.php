<?php
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\widgets\ListView;

$this->title = 'FAQ';


?>

<?= $this->render('/common/breadcrumps')?>

<div class="section-faq">


    <div class="container py-5">


        <div class="accordion accordion-faq" id="faq">

            <?=
            ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'layout' => '{items}',
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_index', ['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this]);
                },
            ])

            ?>


        </div>

    </div>
</div>






