<?php

namespace app\models\mgcms\db;

use Yii;

/**
 * This is the base model class for table "model_attribute".
 *
 * @property integer $rel_id
 * @property string $model
 * @property string $key
 * @property string $value
 */
class ModelAttribute extends \app\models\mgcms\db\AbstractRecord
{
    use \app\components\mgcms\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rel_id', 'model', 'key'], 'required'],
            [['rel_id'], 'integer'],
            [['value'], 'string'],
            [['model', 'key'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'model_attribute';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rel_id' => Yii::t('app', 'Rel ID'),
            'model' => Yii::t('app', 'Model'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\ModelAttributeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\ModelAttributeQuery(get_called_class());
    }
}
