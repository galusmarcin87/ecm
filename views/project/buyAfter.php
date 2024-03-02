<?php
/* @var $this yii\web\View */

/* @var $models \app\models\mgcms\db\Agent[] */

use app\extensions\mgcms\yii2TinymceWidget\TinyMce;
use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use \yii\helpers\Url;
use yii\bootstrap\ActiveForm;


?>

<?= $this->render('/common/breadcrumps') ?>


<section class="companies-wrapper companies-wrapper--dashboard">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-2">
                <h1><?= Yii::t('db', 'Thank you for buying') ?></h1>
                <div><?= MgHelpers::getSetting('buy after ' . $type . ' ' . Yii::$app->language, true, 'buy after ' . $type) ?></div>
                <div><?= Yii::t('db', 'Your smartcontract transaction hash is ' . str_replace(',','<br/>',$transactionHash) ?></div>
            </div>
        </div>
    </div>
</section>
