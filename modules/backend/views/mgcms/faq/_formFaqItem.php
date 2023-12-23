<div class="form-group" id="add-faq-item">
  <?php
  use kartik\grid\GridView;
  use kartik\builder\TabularForm;
  use yii\data\ArrayDataProvider;
  use yii\helpers\Html;
  use yii\widgets\Pjax;

$dataProvider = new ArrayDataProvider([
      'allModels' => $row,
      'pagination' => [
          'pageSize' => -1
      ]
  ]);
  echo TabularForm::widget([
      'dataProvider' => $dataProvider,
      'formName' => 'FaqItem',
      'checkboxColumn' => false,
      'actionColumn' => false,
      'attributeDefaults' => [
          'type' => TabularForm::INPUT_TEXT,
      ],
      'attributes' => [
          "id" => ['type' => TabularForm::INPUT_HIDDEN_STATIC, 'columnOptions' => ['hidden' => true]],
          'question' => ['type' => TabularForm::INPUT_TEXTAREA, 'label' => 'Pytanie'],
          'answer' => ['type' => TabularForm::INPUT_TEXTAREA, 'label' => 'Odpowiedź'],
          'order' => ['type' => TabularForm::INPUT_TEXT, 'label' => 'Kolejność'],
          'del' => [
              'type' => 'raw',
              'label' => '',
              'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' => Yii::t('app', 'Delete'), 'onClick' => 'delRowFaqItem(' . $key . '); return false;', 'id' => 'faq-item-del-btn']);
              },
          ],
          'edit' => [
              'type' => 'raw',
              'label' => '',
              'value' => function($model, $key) {
                return isset($model) && isset($model['id']) ? Html::a('<i class="glyphicon glyphicon-edit"></i>', ['mgcms/faq-item/update', 'id' => $model['id']]) : false;
              },
          ],
      ],
      'gridSettings' => [
          'panel' => [
              'heading' => false,
              'type' => GridView::TYPE_DEFAULT,
              'before' => false,
              'footer' => false,
              'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Faq Item'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowFaqItem()']),
          ]
      ]
  ]);
  echo "    </div>\n\n";

  ?>

