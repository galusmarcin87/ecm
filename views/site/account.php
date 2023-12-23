<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\mgcms\db\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\mgcms\MgHelpers;
use yii\bootstrap\Tabs;

$this->title = Yii::t('db', 'My account');
$this->params['breadcrumbs'][] = $this->title;


?>

<section class="Section Section--big-padding-top Contact animatedParent"></section>


<section class="Section Section--big-padding-top Contact animatedParent myAccount">
    <div class="container">
        <div class="userMain row">
            <? if ($model->file && $model->file->isImage()): ?>
            <div class="col-md-2">
                <img src="<?= $model->file->getImageSrc(210, 210) ?>" alt="" class="rounded-circle"/>
            </div>
            <? endif; ?>

            <div class="col-md-10">
                <h1><?= Yii::t('db', 'Hello') ?> <?= $model ?></h1>
                <p><?= Yii::t('db', 'Number of projects invested') ?>: <?= count($model->paymentsApproved) ?></p>
                <p><?= Yii::t('db', 'The amount of funds invested') ?>
                    : <?= number_format(array_sum(array_column($model->paymentsApproved, 'amount')), 2, '.', ' '); ?></p>
                <p><?= Yii::t('db', 'Assumed profit') ?>
                    : <?= number_format(array_sum(array_column($model->paymentsApproved, 'benefit')), 2, '.', ' '); ?></p>
            </div>

        </div>


        <div class="tabs">
            <?
            $tabsItems = [
                [
                    'label' => MgHelpers::getSettingTranslated('account_tab1', 'My investitions'),
                    'content' => $this->render('account/tokensGrid', [
                        'user' => $model
                    ]),
                    'options' => ['id' => 'myTokens'],
                ],
                [
                    'label' => MgHelpers::getSettingTranslated('account_tab2', 'My data'),
                    'content' => $this->render('account/data', [
                        'model' => $model
                    ]),
                    'options' => ['id' => 'myAccount'],
                ],
                [
                    'label' => MgHelpers::getSettingTranslated('account_tab4', 'My files'),
                    'content' => $this->render('account/files', [
                        'model' => $model
                    ]),
                    'options' => ['id' => 'files'],
                ],
                [
                    'label' => MgHelpers::getSettingTranslated('account_tab3', 'Account settings'),
                    'content' => $this->render('account/settings', [
                        'model' => $model
                    ]),
                    'options' => ['id' => 'settings'],
                ],
            ];

            echo Tabs::widget([
                'items' => $tabsItems,
                'linkOptions' => [
                    'class' => 'btn btn-default'
                ]
            ]);

            ?>
        </div>

    </div>
</section>
