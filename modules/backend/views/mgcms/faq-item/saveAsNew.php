<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\FaqItem */

$this->title = Yii::t('app', 'Save As New {modelClass}: ', [
    'modelClass' =>  Yii::t('app', 'Faq Item'),
]). ' ' . $model->id;


$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Faq Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Save As New');
?>
<div class="faq-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    'model' => $model,
    ]) ?>

</div>
