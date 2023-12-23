<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\TeamMember */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-member-view">

    <div class="row">
        <div class="col-sm-9">
            <h2><?= Yii::t('app', 'Team Member').' '. Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="row">
<?php 
    $gridColumn = [
        ['attribute' => 'id', 'visible' => false],
        'name',
        'surname',
        'is_team',
        'is_consultant',
        'phone',
    ];
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $gridColumn
    ]); 
?>
    </div>
</div>
