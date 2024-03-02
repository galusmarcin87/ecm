<?
/* @var $items \app\models\mgcms\db\User[] */
$companySearchQueryParams = Yii::$app->getRequest()->getQueryParam('CompanySearch');
$currentUserId = $companySearchQueryParams && isset($companySearchQueryParams['created_by']) ? $companySearchQueryParams['created_by'] : false;
?>

<ol class="dd-list">
    <?php foreach ($items as $item): ?>
        <li class="dd-item" data-id="<?php echo $item->id ?>">
            <div class="dd-handle <?= $currentUserId == $item->id ? 'active' : '' ?>"
                 data-user-id="<?= $item->id ?>"><?= $item ?> - <?= Yii::t('db', $item->role) ?></div>
            <?php if (!empty($item->children)): ?>
                <?php echo $this->render('_submenu', array('items' => $item->children)); ?>
            <?php endif ?>
        </li>
    <?php endforeach ?>
</ol>
