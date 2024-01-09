<?php
/* @var $this yii\web\View */

/* @var $model \app\models\mgcms\db\User */

use app\models\mgcms\db\Project;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\helpers\Url;

$newestCampaign = Project::find()->where(['status' => Project::STATUS_ACTIVE])->orderBy('id DESC')->one();
$query = Project::find()->where(['status' => Project::STATUS_ACTIVE]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 6,
    ],
    'sort' => [
        'attributes' => [
            'order' => SORT_ASC,
        ]
    ],
]);
$this->title = Yii::t('db', 'Main panel');
?>

<?= $this->render('/common/breadcrumps') ?>

<?= $this->render('_investor') ?>
<div class="account-page">
    <div class="container">


        <div class="row gx-4">

            <?= $this->render('_leftNav', ['tab' => $tab]) ?>

            <div class="col-lg-8 account-content-col">


                <div class="account-main-block">

                    <h2 class="section-title section-title--small">
                        <?= Yii::t('db', 'My account') ?>
                    </h2>
                    <a href="<?= Url::to('/account/connect-with-stripe') ?>"
                       class="btn btn-primary"><?= Yii::t('db', 'Connect with Stripe') ?></a>

                    <? if (!$model->isVerified): ?>
                        <a href="<?= Url::to('/account/verify-by-veriff') ?>"
                           class="btn btn-primary"><?= Yii::t('db', 'Verify') ?></a>
                    <? endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
