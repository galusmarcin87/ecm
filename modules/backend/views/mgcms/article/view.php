<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="article-view">

  <div class="row">
    <div class="col-sm-9">
      <h2><?= Yii::t('app', 'Article') . ' ' . Html::encode($this->title) ?></h2>
    </div>
    <div class="col-sm-3" style="margin-top: 15px">
      <?=
      Html::a('<i class="fa glyphicon glyphicon-hand-up"></i> ' . Yii::t('app', 'PDF'), ['pdf', 'id' => $model->id], [
          'class' => 'btn btn-danger',
          'target' => '_blank',
          'data-toggle' => 'tooltip',
          'title' => Yii::t('app', 'Will open the generated PDF file in a new window')
          ]
      )

      ?>

      <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      <?=
      Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger',
          'data' => [
              'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
              'method' => 'post',
          ],
      ])

      ?>
    </div>
  </div>

<?= $this->render('/common/_images', ['model' => $model, 'editable' => false]) ?>
  <div class="row">
  <?php
  $gridColumn = [
      ['attribute' => 'id', 'visible' => false],
      'title',
      'link:html',
      'language',
      'created_on',
      'updated_on',
      'status:translate',
      [
          'attribute' => 'file.link',
          'format' => 'raw',
          'label' => Yii::t('app', 'File'),
      ],
	  'meta_title',
      'meta_description',
      'meta_keywords',
      'tagString',
  ];
  echo DetailView::widget([
      'model' => $model,
      'attributes' => $gridColumn
  ]);

  ?>
  </div>

<? if ($model->file): ?>
    <? if ($model->file->isImage()): ?>
      <?= $model->file->thumb ?>
    <? else: ?>
      <a class="top10" href="<?= $model->file->webPath ?>"><?= $model->file ?></a>
    <? endif ?>
  <? endif ?>


  <div class="row">
    <h2><?= Yii::t('app', 'Content') ?></h2>
<?= $model->content ?>
  </div>

  <div class="row">
    <h2><?= Yii::t('app', 'Excerpt') ?></h2>
<?= $model->excerpt ?>
  </div>
</div>