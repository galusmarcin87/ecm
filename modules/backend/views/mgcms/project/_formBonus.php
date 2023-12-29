<div class="form-group" id="add-bonus">
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
        'formName' => 'Bonus',
        'checkboxColumn' => false,
        'actionColumn' => false,
        'attributeDefaults' => [
            'type' => TabularForm::INPUT_TEXT,
        ],
        'attributes' => [
            "id" => ['type' => TabularForm::INPUT_HIDDEN_STATIC, 'columnOptions' => ['hidden' => true]],
            'from' => ['type' => TabularForm::INPUT_TEXT, 'label' => 'Nagłówek'],
            'to' => ['type' => TabularForm::INPUT_HIDDEN, 'label' => 'Do','value' => 1, 'columnOptions' => ['hidden' => true]],
            'value' => ['type' => TabularForm::INPUT_TEXT, 'label' => 'Tekst'],
            'language' => ['type' => TabularForm::INPUT_DROPDOWN_LIST, 'items'=>MgHelpers::arrayKeyValueFromArray(MgHelpers::getConfigParam('languagesDisplay'))],
            'del' => [
                'type' => 'raw',
                'label' => '',
                'value' => function ($model, $key) {
                    return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' => Yii::t('app', 'Usuń'), 'onClick' => 'delRowBonus(' . $key . '); return false;', 'id' => 'bonus-del-btn']);
                },
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Dodaj'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowBonus()']),
            ]
        ]
    ]);
    echo "    </div>\n\n";
    ?>

