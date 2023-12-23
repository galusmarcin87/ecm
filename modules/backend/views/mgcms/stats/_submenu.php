<?
/* @var $items \app\models\mgcms\db\User[] */
?>

<ol class="dd-list">
    <?php foreach ($items as $item): ?>
        <li class="dd-item" data-id="<?php echo $item->id ?>">
            <div class="dd-handle"
                 data-user-id="<?= $item->id ?>"><?= $item ?> - <?= Yii::t('db', $item->role) ?>
                (<?= isset($provisions[$item->id]) ? $provisions[$item->id] : 0 ?>)
            </div>
            <?php if (!empty($item->children)): ?>
                <?php echo $this->render('_submenu', array('items' => $item->children, 'provisions' => $provisions)); ?>
            <?php endif ?>
        </li>
    <?php endforeach ?>
</ol>
