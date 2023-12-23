<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Auth */

$this->title = Yii::t('db', 'Provisions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statistics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row-fluid dd" id="menuNestable">
        <?php echo $this->render('_submenu', array('items' => $user->children, 'provisions' => $provisions)); ?>
    </div>


</div>
