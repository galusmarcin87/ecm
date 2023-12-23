<?php
namespace app\models\mgcms\db;

use Yii;
use \yii\helpers\Json;

/**
 * This is the base model class for table "file_relation".
 *
 * @property integer $file_id
 * @property integer $rel_id
 * @property string $model
 * @property string $json
 * @property File $file
 */
class FileRelation extends \app\models\mgcms\db\AbstractRecord
{
//    use \mootensai\relation\RelationTrait;

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['file_id', 'rel_id', 'model'], 'required'],
        [['file_id', 'rel_id', 'order'], 'integer'],
        [['model'], 'string', 'max' => 255],
        [['json'], 'safe'],
    ];
  }

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'file_relation';
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'file_id' => Yii::t('app', 'File ID'),
        'rel_id' => Yii::t('app', 'Rel ID'),
        'model' => Yii::t('app', 'Model'),
    ];
  }

  /**
   * @inheritdoc
   * @return \app\models\mgcms\db\FileRelationQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\mgcms\db\FileRelationQuery(get_called_class());
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getFile()
  {
    return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'file_id']);
  }

  /**
   *
   * @param type $data
   */
  public static function setJsonAttributes($data)
  {
    foreach ($data as $fileId => $fileData) {
      foreach ($fileData as $relId => $relData) {
        foreach ($relData as $model => $attributes) {
          $fileRelation = \app\models\mgcms\db\FileRelation::find()->where(['rel_id' => $relId, 'file_id' => $fileId, 'model' => $model])->one();
          if ($fileRelation) {
            $jsonData = Json::decode($fileRelation->json);
            if (!$jsonData) {
              $jsonData = [];
            }
            foreach ($attributes as $attribute => $value) {
              $jsonData[$attribute] = $value;
            }
            $fileRelation->json = Json::encode($jsonData);
            $fileRelation->save();
          }
        }
      }
    }
  }

  /**
   *
   * @param type $fileId
   * @param type $relId
   * @param type $model
   */
  public static function getJsonAttributes($fileId, $relId, $model)
  {
    $fileRelation = \app\models\mgcms\db\FileRelation::find()->where(['rel_id' => $relId, 'file_id' => $fileId, 'model' => $model])->one();
    if (!$fileRelation) {
      return [];
    }
    $jsonDecoded = Json::decode($fileRelation->json);
    return $jsonDecoded ? $jsonDecoded : [];
  }

  /**
   *
   * @param type $fileId
   * @param type $relId
   * @param type $model
   * @param type $name
   */
  public static function getJsonAttribute($fileId, $relId, $model, $name)
  {
    $jsonAttributes = self::getJsonAttributes($fileId, $relId, $model);
    return array_key_exists($name, $jsonAttributes) ? $jsonAttributes[$name] : false;
  }
}
