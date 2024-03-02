<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Project */

?>
<div class="project-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Html::encode($model->name) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'title',
        'lead:ntext',
        'description:ntext',
        'presale_date_from',
        'presale_date_to',
        'sale_date_from',
        'sale_date_to',
        'token_specification:ntext',
        'project_link',
        'facebook',
        'twitter',
        'instagram',
        'flikr',
        'more_informations:ntext',
        'money_gathered',
        'money_full',
        'pre_ico_percentage',
        [
            'attribute' => 'logo.name',
            'label' => Yii::t('app', 'Logo'),
        ],
        [
            'attribute' => 'picture.name',
            'label' => Yii::t('app', 'Picture'),
        ],
        [
            'attribute' => 'whitepapera.name',
            'label' => Yii::t('app', 'Whitepapera'),
        ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>