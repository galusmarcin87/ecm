<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Agent */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agent'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Agent').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'full_name',
        'position',
        'description:ntext',
        'phone',
        [
                'attribute' => 'file.name',
                'label' => Yii::t('app', 'File')
            ],
        'email:email',
        'agentcol',
        [
                'attribute' => 'company.name',
                'label' => Yii::t('app', 'Company')
            ],
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
