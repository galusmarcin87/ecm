<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\mgcms\db\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);

?>
<div class="menu-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

  <p>
    <?= Html::a(Yii::t('app', 'Create Menu'), ['create'], ['class' => 'btn btn-success']) ?>
  </p>
  <?php
  $gridColumn = [
      ['class' => 'yii\grid\SerialColumn'],
      ['attribute' => 'id', 'visible' => false],
      [
          'class' => app\components\mgcms\yii\ActionColumn::className(),
          'template' => '{view} {update} {manage} {delete}',
          'buttons' => [
              'manage' => function ($url, $model) {
                  return Html::a('<span class="glyphicon glyphicon-cog"></span>', $url, [
                      'title' => Yii::t('app', 'Manage'),
                  ]);
              },],
      ],
      'name',

  ];

  ?>
  <?=
  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => $gridColumn,
      'pjax' => true,
      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-menu']],
      'panel' => [
          'type' => GridView::TYPE_PRIMARY,
          'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
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
