<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('app', 'Files');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
//$this->registerJs($search);

?>
<div class="file-index">
  <p>
    <?= Html::a(Yii::t('app', 'Create File'), ['create', 'emptyLayout' => true], ['class' => 'btn btn-success']) ?>
  </p>
  <?php
  $gridColumn = [
      ['class' => 'yii\grid\SerialColumn'],
      ['attribute' => 'id', 'visible' => false],
      'thumb:raw',
      [
          'header' => Yii::t('app', 'Name'),
          'value' => 'link',
          'format' => 'raw',
          'attribute' => 'origin_name'
      ],
//        'mime',
      'size:size',
      'created_on:datetime',
      [
          'class' => app\components\mgcms\yii\ActionColumn::className(),
          'template' => '{choose_file}',
          'buttons' => [
              'choose_file' => function ($url, $model) {
                /* @var $model app\models\mgcms\db\File */
                return Html::a('<span class="glyphicon glyphicon-ok"></span>', 'javascript:chooseFile(' . $model->id . ',\'' . $model->webPath . '\',' . (int) $model->isImage() . ')', [
                        'title' => Yii::t('app', 'Manage'),
                ]);
              },],
      ],
  ];

  ?>
  <?=
  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => $gridColumn,
      'pjax' => false,
      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-file']],
      'panel' => [
          'type' => GridView::TYPE_PRIMARY,
          'heading' => '<span class="glyphicon glyphicon-file"></span>  ' . Html::encode($this->title),
      ],
      'export' => false,
      // your toolbar can include the additional full export menu
      'toolbar' => [
          '{export}',
          ExportMenu::widget([
              'dataProvider' => $dataProvider,
              'columns' => $gridColumn,
              'target' => ExportMenu::TARGET_BLANK,
              'fontAwesome' => true,
              'dropdownOptions' => [
                  'label' => 'Full',
                  'class' => 'btn btn-default',
                  'itemsBefore' => [
                      '<li class="dropdown-header">Export All Data</li>',
                  ],
              ],
              'exportConfig' => [
                  ExportMenu::FORMAT_PDF => false
              ]
          ]),
      ],
  ]);

  ?>

</div>

<script type="text/javascript">
  function chooseFile(fileId, fileSrc, isImage) {
    parent.chooseFile(fileId, fileSrc, isImage);
  }
</script>