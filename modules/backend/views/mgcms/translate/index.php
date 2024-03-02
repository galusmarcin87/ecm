<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\mgcms\db\I18nSourceMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = Yii::t('app', 'Translations');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);

?>
<div class="i18n-source-message-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php
  $gridColumn = [
      ['class' => 'yii\grid\SerialColumn'],
      ['attribute' => 'id', 'visible' => false],
      [
          'class' => app\components\mgcms\yii\ActionColumn::className(),
          'template' => '{delete}'
      ],
      'category',
      'message:ntext',
      array(
          'header' => Yii::t('app', 'Translations'),
          'value' => 'translateLinks',
          'format' => 'raw'
      ),

  ];

  ?>
  <?=
  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => $gridColumn,
      'pjax' => true,
      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-i18n-source-message']],
      'panel' => [
          'type' => GridView::TYPE_PRIMARY,
          'heading' => '<span class="glyphicon glyphicon-flag"></span>  ' . Html::encode($this->title),
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
