
<ol class="dd-list">
  <?php foreach ($items as $item): ?>

    <li class="dd-item" data-id="<?php echo $item['id'] ?>">
      <div class="dd-handle"><?php echo $item->article ? $item->article->title : ($item->category ? $item->category->name : $item->label) ?> </div>
      <? if (!$item->article && !$item->category): ?>
        <a style="position:absolute; right: 20px; top: 5px"  data-toggle="modal" data-target="#<?= 'edit' . $item['id'] ?>"><?= \kartik\icons\Icon::show('edit') ?></a>
        <?= $this->render('_menuItemModal', ['model' => $item]) ?>
      <? endif ?>
      <a style="position:absolute; right: 5px; top: 5px" class="delete" rel="tooltip" href="#" data-original-title="Usuń"><?= \kartik\icons\Icon::show('trash') ?></a>
      <?php if (!empty($item->children)): ?>
        <?php echo $this->render('_submenu', array('items' => $item->children)); ?>
      <?php endif ?>
    </li>
  <?php endforeach ?>
</ol>