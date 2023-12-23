<div class="form-group" id="add-slide">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;

$model = new \app\models\mgcms\db\Slide;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Slide',
    'checkboxColumn' => false,
    'actionColumn' => false,
    'attributeDefaults' => [
        'type' => TabularForm::INPUT_TEXT,
    ],
    'attributes' => [
        "id" => app\components\mgcms\MgHelpers::getCRUDIdColumn(),
        'name' => ['type' => TabularForm::INPUT_TEXT, 'label' => $model->getAttributeLabel('name')],
        'link' => ['type' => TabularForm::INPUT_TEXT, 'label' => $model->getAttributeLabel('link')],
        'header' => ['type' => TabularForm::INPUT_TEXT, 'label' => $model->getAttributeLabel('header')],
        'subheader' => ['type' => TabularForm::INPUT_TEXT, 'label' => $model->getAttributeLabel('subheader')],
        'body' => ['type' => TabularForm::INPUT_TEXTAREA, 'label' => $model->getAttributeLabel('body')],
        'order' => ['type' => TabularForm::INPUT_TEXT, 'label' => $model->getAttributeLabel('order')],
        'file_id' => [
            'label' => $model->getAttributeLabel('file_id'),
            'type' => TabularForm::INPUT_WIDGET,
            'widgetClass' => \kartik\widgets\Select2::className(),
            'options' => [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\File::find()->orderBy('origin_name')->asArray()->all(), 'id', 'origin_name'),
                'options' => ['placeholder' => Yii::t('app', 'Choose File')],
            ],
            'columnOptions' => ['width' => '200px']
        ],
        'del' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  Yii::t('app', 'Delete'), 'onClick' => 'delRowSlide(' . $key . '); return false;', 'id' => 'slide-del-btn']);
            },
        ],
    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Slide'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowSlide()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

