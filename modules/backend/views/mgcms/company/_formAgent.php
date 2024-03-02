<div class="form-group" id="add-agent">
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
        'formName' => 'Agent',
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
                'value' => function ($model, $key) {
                    return Html::a('<i class="glyphicon glyphicon-trash"></i>', '#', ['title' => Yii::t('app', 'Delete'), 'onClick' => 'delRowAgent(' . $key . '); return false;', 'id' => 'agent-del-btn']);
                },
            ],

            'user_id' => [
                'label' => Yii::t('db', 'User'),
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => \kartik\widgets\Select2::className(),
                'options' => [
                    'data' => \yii\helpers\ArrayHelper::map(\app\models\mgcms\db\User::find()->andWhere(['role' => [\app\models\mgcms\db\User::ROLE_REPRESENTATIVE, \app\models\mgcms\db\User::ROLE_CLIENT]])->orderBy('last_name')->all(), 'id', 'toString'),
                    'options' => ['placeholder' => Yii::t('app', 'Choose User')],
                ],
                'columnOptions' => ['width' => '200px']
            ],

        ],
        'gridSettings' => [
            'panel' => [
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="glyphicon glyphicon-plus"></i>' . Yii::t('app', 'Add Agent'), ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowAgent()']),
            ]
        ]
    ]);
    echo "    </div>\n\n";
    ?>

