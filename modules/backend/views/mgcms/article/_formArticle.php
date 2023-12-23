<div class="form-group" id="add-article">
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
    'formName' => 'Article',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => ['type' => TabularForm::INPUT_HIDDEN, 'visible' => false],
        'title' => ['type' => TabularForm::INPUT_TEXT],
        'content' => ['type' => TabularForm::INPUT_TEXTAREA],
        'slug' => ['type' => TabularForm::INPUT_TEXT],
        'excerpt' => ['type' => TabularForm::INPUT_TEXTAREA],
        'language' => ['type' => TabularForm::INPUT_TEXT],
        'created_on' => ['type' => TabularForm::INPUT_TEXT],
        'updated_on' => ['type' => TabularForm::INPUT_TEXT],
        'meta_title' => ['type' => TabularForm::INPUT_TEXT],
        'meta_description' => ['type' => TabularForm::INPUT_TEXT],
        'meta_keywords' => ['type' => TabularForm::INPUT_TEXT],
        'status' => ['type' => TabularForm::INPUT_TEXT],
        'category_id' => [
            'label' => 'Category',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\Category::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => Yii::t('app', 'Choose Category')],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'file_id' => [
            'label' => 'File',
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                'options' => ['placeholder' => Yii::t('app', 'Choose File')],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'order' => ['type' => TabularForm::INPUT_TEXT],
        'promoted' => ['type' => TabularForm::INPUT_CHECKBOX,
            'options' => [
                'style' => 'position : relative; margin-top : -9px'
            ]
        ],
        'custom' => ['type' => TabularForm::INPUT_TEXTAREA],
        'type' => ['type' => TabularForm::INPUT_TEXT],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  Yii::t('app', 'Delete'), 'onClick' => 'delRowArticle(' . $key . '); return false;', 'id' => 'article-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Article'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowArticle()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

