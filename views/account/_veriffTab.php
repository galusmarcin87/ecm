<?php
/* @var $this yii\web\View */

/* @var $model \app\models\mgcms\db\User */

use app\models\mgcms\db\Project;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\helpers\Url;


$this->title = Yii::t('db', 'Verification by Veriff');
?>

<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text']) ?>

<?= $this->render('_investor') ?>
<div class="account-page">
    <div class="container">


        <div class="row gx-4">

            <?= $this->render('_leftNav', ['tab' => $tab]) ?>

            <div class="col-lg-9 account-content-col">


                <div class="account-main-block">
					
					<div class="mb-9"><?= Yii::t('db', 'Verification text') ?></div>

                    <center><div class="mb-6"><? if (!$model->is_verified): ?>
                        <a href="<?= Url::to('/account/verify-by-veriff') ?>"
                           class="btn btn-primary"><?= Yii::t('db', 'Verify') ?></a>
                    <? endif; ?></div></center>

                </div>
            </div>

        </div>
    </div>
</div>
