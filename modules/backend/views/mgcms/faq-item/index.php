<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\mgcms\db\FaqItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('app', 'Faq Items');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);

?>
<div class="faq-item-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <p>
    <? $controller = Yii::$app->controller->id;
    if (\app\components\mgcms\MgHelpers::getUserModel()->checkAccess($controller, 'create')):

      ?>
      <?= Html::a(Yii::t('app', 'Create Faq Item'), ['create'], ['class' => 'btn btn-success']) ?>
  <? endif ?>
  </p>
  <?php
  $gridColumn = [
      ['class' => 'yii\grid\SerialColumn'],
      [
          'class' => 'kartik\grid\ExpandRowColumn',
          'width' => '50px',
          'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
          },
          'detail' => function ($model, $key, $index, $column) {
            return Yii::$app->controller->renderPartial('_expand', ['model' => $model]);
          },
          'headerOptions' => ['class' => 'kartik-sheet-style'],
          'expandOneOnly' => true
      ],
      ['attribute' => 'id', 'visible' => false],
      'question:ntext',
      'answer:ntext',
      [
          'attribute' => 'faq_id',
          'label' => Yii::t('app', 'Faq'),
          'value' => function($model) {
            return $model->faq->name;
          },
          'filterType' => GridView::FILTER_SELECT2,
          'filter' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Faq::find()->asArray()->all(), 'id', 'name'),
          'filterWidgetOptions' => [
              'pluginOptions' => ['allowClear' => true],
          ],
          'filterInputOptions' => ['placeholder' => Yii::t('app', 'Faq'), 'id' => 'grid-faq-item-search-faq_id']
      ],
      'order',
      [
          'class' => app\components\mgcms\yii\ActionColumn::className(),
          'template' => '{save-as-new} {view} {update} {delete}',
          'buttons' => [
              'save-as-new' => function ($url) {
                return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, ['title' => 'Save As New']);
              },
          ],
      ],
  ];

  ?>
  <?=
  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => $gridColumn,
      'pjax' => true,
      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-faq-item']],
      'panel' => [
          'type' => GridView::TYPE_PRIMARY,
          'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
      ],
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
          ]),
      ],
  ]);

  ?>

</div>
