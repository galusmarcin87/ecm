<?php
/* @var $this yii\web\View */

/* @var $model \app\models\mgcms\db\User */

use app\models\mgcms\db\Project;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\helpers\Url;


$this->title = Yii::t('db', 'Calendar');
?>

<?= $this->render('/common/breadcrumps') ?>

<?= $this->render('_investor') ?>
<div class="account-page">
    <div class="container">


        <div class="row gx-4">

            <?= $this->render('_leftNav', ['tab' => $tab]) ?>

            <div class="col-lg-9 account-content-col">


                <div class="account-main-block">

                    <h2 class="section-title section-title--small">
                        <?= Yii::t('db', 'Calendar') ?>
                    </h2>

                    <?= \app\components\mgcms\MgHelpers::getSettingTypeText('myaaccount calendar text '.Yii::$app->language,true,'myaaccount calendar text ')?>

                </div>
            </div>

        </div>
    </div>
</div>