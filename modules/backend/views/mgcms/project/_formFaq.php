<div class="form-group" id="add-faq">
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
        'formName' => 'Faq',
        'checkboxColumn' => false,
        'actionColumn' => false,
        'attributeDefaults' => [
            'type' => TabularForm::INPUT_TEXT,
        ],
        'attributes' => [
            "id" => ['type' => TabularForm::INPUT_HIDDEN_STATIC, 'columnOptions' => ['hidden' => true]],
            'from' => ['type' => TabularForm::INPUT_TEXT, 'label' => 'Pytanie'],
            'to' => ['type' => TabularForm::INPUT_HIDDEN, 'label' => 'Do', 'value' => 2, 'columnOptions' => ['hidden' => true]],
            'value' => ['type' => TabularForm::INPUT_TEXT, 'label' => 'Odpowiedź'],
            'del' => [
                'type' => 'raw',
                'label' => '',
                'value' => function ($model, $key) {
                    return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' => Yii::t('app', 'Usuń'), 'onClick' => 'delRowFaq(' . $key . '); return false;', 'id' => 'faq-del-btn']);
                },
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Dodaj'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowFaq()']),
            ]
        ]
    ]);
    echo "    </div>\n\n";
    ?>

