<div class="form-group" id="add-job">
<?php
use kartik\grid\GridView;
use kartik\builder\TabularForm;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\components\mgcms\MgHelpers;

$dataProvider = new ArrayDataProvider([
    'allModels' => $row,
    'pagination' => [
        'pageSize' => -1
    ]
]);
echo TabularForm::widget([
    'dataProvider' => $dataProvider,
    'formName' => 'Job',
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
                return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' =>  Yii::t('app', 'Delete'), 'onClick' => 'delRowJob(' . $key . '); return false;', 'id' => 'job-del-btn']);
            },
        ],
        'edit' => [
            'type' => 'raw',
            'label' => '',
            'value' => function($model, $key) {
                return isset($model) && isset($model['id']) && $model['id'] ? Html::a('<i class="glyphicon glyphicon-edit"></i>',
                    ['mgcms/job/update', 'id' => $model['id']]) : false;
            },
        ],
        'name' => ['type' => TabularForm::INPUT_TEXT],
        'position' => ['type' => TabularForm::INPUT_TEXT],
        'salary' => ['type' => TabularForm::INPUT_TEXT],
        'industry' => ['type' => TabularForm::INPUT_DROPDOWN_LIST, 'items' => MgHelpers::getSettingOptionArrayTranslated('industries array'), 'options'=>['prompt' => '']],
        'country' => ['type' => TabularForm::INPUT_DROPDOWN_LIST, 'items' => MgHelpers::getSettingOptionArrayTranslated('countries array'), 'options'=>['prompt' => '']],
        'city' => ['type' => TabularForm::INPUT_TEXT],


    ],
    'gridSettings' => [
        'panel' => [
            'heading' => false,
            'type' => GridView::TYPE_DEFAULT,
            'before' => false,
            'footer' => false,
            'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Job'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowJob()']),
        ]
    ]
]);
echo  "    </div>\n\n";
?>

