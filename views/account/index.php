<?php
/* @var $this yii\web\View */
/* @var $model \app\models\mgcms\db\User*/

use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use \yii\helpers\Url;


$this->params['breadcrumbs'][] = ['/account', Yii::t('db', 'My Account')];
?>



<?= $this->render('_' . $tab . 'Tab', ['tab' => $tab, 'model' => $model]) ?>

