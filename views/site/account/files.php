<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\mgcms\db\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\mgcms\MgHelpers;
use yii\bootstrap\Tabs;


?>

<section class="Section Section--big-padding-top">
    <div class="">
        <? if ($model->file_text): ?>

            <? $fileArr = explode("\n", $model->file_text); ?>
            <? foreach ($fileArr as $file): $fileParts = explode(';', $file) ?>
                <? if (count($fileParts) !== 2) continue ?>
                <a href="<?= $fileParts[1]?>" class="btn" target="_blank"><?= $fileParts[0]?></a>
            <? endforeach; ?>

        <? else: ?>

            <p><?= Yii::t('db', 'You have no files') ?></p>
        <? endif ?>
    </div>
</section>
