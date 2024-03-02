<div class="form-group" id="add-product">
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
    'formName' => 'Product',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN_STATIC, 'columnOptions' => ['hidden' => true]],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  Yii::t('app', 'Delete'), 'onClick' => 'delRowProduct(' . $key . '); return false;', 'id' => 'product-del-btn']);
            },
        ],
        'edit' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return isset($model) && isset($model['id']) && $model['id'] ? Html::a('<i class="glyphicon glyphicon-edit"></i>',
                    ['mgcms/product/update', 'id' => $model['id']]) : false;
            },
        ],
        'name' => ['type' => TabularForm::INPUT_TEXT],
        'category_id' => [
            'label' => 'Category',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Category::find()->andWhere(['type'=>\app\models\mgcms\db\Category::TYPE_PRODUCT_TYPE])->orderBy('name')->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => Yii::t('app', 'Choose Category')],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'number' => ['type' => TabularForm::INPUT_TEXT],
        'min_amount_of_purchase' => ['type' => TabularForm::INPUT_TEXT],
        'price' => ['type' => TabularForm::INPUT_TEXT]
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Product'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowProduct()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

