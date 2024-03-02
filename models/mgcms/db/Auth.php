<?php

namespace app\models\mgcms\db;

use Yii;

/**
 * This is the model class for table "auth".
 *
 * @property integer $id
 * @property string $controller
 * @property string $action
 * @property string $role
 * @property integer $value
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'integer'],
            [['controller', 'action', 'role'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'controller' => Yii::t('app', 'Controller'),
            'action' => Yii::t('app', 'Action'),
            'role' => Yii::t('app', 'Role'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
}
