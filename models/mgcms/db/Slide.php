<?php
namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;

/**
 * This is the base model class for table "slide".
 *
 * @property integer $id
 * @property string $name
 * @property string $header
 * @property string $subheader
 * @property string $body
 * @property integer $order
 * @property integer $file_id
 * @property integer $slider_id
 * @property string $link
 *
 * @property \app\models\mgcms\db\File $file
 * @property \app\models\mgcms\db\Slider $slider
 */
class Slide extends \app\models\mgcms\db\AbstractRecord
{

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['name', 'slider_id'], 'required'],
        [['body'], 'string'],
        [['file_id', 'slider_id' ,'order'], 'integer'],
        [['name', 'header', 'subheader', 'link'], 'string', 'max' => 245]
    ];
  }

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'slide';
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'id' => Yii::t('app', 'ID'),
        'name' => Yii::t('app', 'Link label'),
        'header' => Yii::t('app', 'Header'),
        'subheader' => Yii::t('app', 'Subheader'),
        'body' => Yii::t('app', 'Lead'),
        'file_id' => Yii::t('app', 'File'),
        'file' => Yii::t('app', 'File'),
        'slider_id' => Yii::t('app', 'Slider'),
        'slider' => Yii::t('app', 'Slider'),
        'order' => Yii::t('app', 'Order'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getFile()
  {
    return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'file_id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getSlider()
  {
    return $this->hasOne(\app\models\mgcms\db\Slider::className(), ['id' => 'slider_id']);
  }

  /**
   * @inheritdoc
   * @return \app\models\mgcms\db\SlideQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\mgcms\db\SlideQuery(get_called_class());
  }
}
