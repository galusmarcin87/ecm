<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\mgcms\db\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
$search = "$('.search-button').click(function(){
	$('.search-form').toggle(1000);
	return false;
});";
$this->registerJs($search);

?>
<div class="category-index">

  <h1><?= Html::encode($this->title) ?></h1>
  <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

  <p>
    <?= Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']) ?>
    <? // Html::a(Yii::t('app', 'Advance Search'), '#', ['class' => 'btn btn-info search-button']) ?>
  </p>
  <div class="search-form" style="display:none">
    <? //  $this->render('_search', ['model' => $searchModel]);  ?>
  </div>
  <?php
  $gridColumn = [
      ['class' => 'yii\grid\SerialColumn'],
      ['attribute' => 'id', 'visible' => false],
      [
          'class' => app\components\mgcms\yii\ActionColumn::className(),
      ],
      [
          'class' => 'kartik\grid\EditableColumn',
          'attribute' => 'name',
          'editableOptions' => [
              'size' => 'md',
              'inputType' => \kartik\editable\Editable::INPUT_TEXT,
          ],
      ],
      [
          'attribute' => 'link',
          'value' => function($model) {
            return $model->getLink(Yii::t('app', 'Link'));
          },
          'format' => 'raw'
      ],
      [
          'attribute' => 'type',
          'filter' => app\components\mgcms\MgHelpers::arrayKeyValueFromArray(\app\models\mgcms\db\Category::TYPES, true),
          'format' => 'translate'
      ],
      [
          'attribute' => 'language',
          'filter' => app\components\mgcms\MgHelpers::arrayKeyValueFromArray(MgHelpers::getConfigParam('languages'), true),
      ],
      [
          'attribute' => 'parent_id',
          'label' => Yii::t('app', 'Parent'),
          'value' => function($model) {
            return isset($model->parent) ? $model->parent->name : false;
          },
          'filterType' => GridView::FILTER_SELECT2,
          'filter' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Category::find()->asArray()->all(), 'id', 'name'),
          'filterWidgetOptions' => [
              'pluginOptions' => ['allowClear' => true],
          ],
          'filterInputOptions' => ['placeholder' => Yii::t('app', 'Category'), 'id' => 'grid-category-search-parent_id']
      ],
      'order',
      'promoted:boolean',

  ];

  ?>
  <?=
  GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => $gridColumn,
      'pjax' => true,
      'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-category']],
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
