<?php
namespace app\models\mgcms\db\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "i18n_message".
 *
 * @property integer $id
 * @property string $language
 * @property string $translation
 *
 * @property \app\models\mgcms\db\I18nSourceMessage $id0
 */
class I18nMessage extends \app\models\mgcms\db\AbstractRecord
{


  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['id', 'language'], 'required'],
        [['id'], 'integer'],
        [['translation'], 'string'],
        [['language'], 'string', 'max' => 16]
    ];
  }

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'i18n_message';
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'id' => Yii::t('app', 'ID'),
        'language' => Yii::t('app', 'Language'),
        'translation' => Yii::t('app', 'Translation'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getSourceMessage()
  {
    return $this->hasOne(\app\models\mgcms\db\I18nSourceMessage::className(), ['id' => 'id']);
  }


  /**
   * @inheritdoc
   * @return \app\models\mgcms\db\I18nMessageQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\mgcms\db\I18nMessageQuery(get_called_class());
  }

}
