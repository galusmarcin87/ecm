<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\I18nSourceMessage */

$this->title = Yii::t('app', 'Update I18n Source Message') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'I18n Source Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="i18n-source-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
