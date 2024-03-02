<?php
/* @var $this yii\web\View */

/* @var $payments Payment[] */

use yii\helpers\Html;
use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Payment;

?>


<div class="User-Panel__form Contact-form animatedParent">
    <? if (sizeof($payments) == 0): ?>
        <p><?= Yii::t('db', 'You do not have any tokens'); ?></p>
    <? else: ?>
        <? foreach ($payments as $payment): ?>
            <div class="metrics">
                <h4 class="green"><?= Yii::t('db', 'Payment'); ?></h4>
                <p><?= Yii::t('db', 'Payment value'); ?>: &nbsp;<b> <?= $payment->amount ?></b></p>
                <p><?= Yii::t('db', 'Date of tokens purchased'); ?>: &nbsp;<b><?= $payment->created_on ?></b></p>
                <p><?= Yii::t('db', 'Status'); ?>:
                    &nbsp;<b><?= Yii::t('db', Payment::STATUSES[$payment->status]); ?></b></p>
            </div>
        <? endforeach ?>
    <? endif; ?>
</div>
