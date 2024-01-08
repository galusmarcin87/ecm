<?php

/* @var $this yii\web\View */

$user = \app\components\mgcms\MgHelpers::getUserModel();

?>


<div class="container">
    <div class="account-bar">
        <div class="account-bar-content">
            <? if ($user->file && $user->file->isImage()): ?>
                <div class="account-bar-avatar">
                    <img src="<?= $user->file->getImageSrc(95, 95) ?>" alt="OC" class="img-fluid rounded-circle">
                </div>
            <? endif; ?>

            <div class="account-bar-text">
                <div class="name">
                    <?= $user ?>
                </div>
                <div class="experience">
                    <?= Yii::t('db', $user->role) ?>
                </div>
            </div>
            <div class="account-bar-menu-toggle">
                <button class="btn d-lg-none" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasAccount" aria-controls="offcanvasAccount"><?= Yii::t('db', 'Panel menu') ?>
                </button>
            </div>
        </div>
    </div>
</div>
