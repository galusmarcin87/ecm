<?php

namespace app\models\mgcms\db\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "i18n_source_message".
 *
 * @property integer $id
 * @property string $category
 * @property string $message
 *
 * @property \app\models\mgcms\db\I18nMessage[] $i18nMessages
 */
class I18nSourceMessage extends \app\models\mgcms\db\AbstractRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category'], 'string', 'max' => 255],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'i18n_source_message';
    }

    

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI18nMessages()
    {
        return $this->hasMany(\app\models\mgcms\db\I18nMessage::className(), ['id' => 'id']);
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
  
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\I18nSourceMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\I18nSourceMessageQuery(get_called_class());
    }
}
