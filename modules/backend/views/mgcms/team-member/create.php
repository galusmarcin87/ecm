<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\TeamMember */

$this->title = Yii::t('app', 'Create Team Member');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Team Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
