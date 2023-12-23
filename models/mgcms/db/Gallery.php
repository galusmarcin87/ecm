<?php
namespace app\models\mgcms\db;

use yii\behaviors\SluggableBehavior;
use \app\components\mgcms\MgHelpers;
use Yii;

/**
 * This is the base model class for table "gallery".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $created_on
 * @property integer $created_by
 * @property integer $order
 * @property string $description
 * @property integer $promoted
 *
 * @property \app\models\mgcms\db\User $createdBy
 * @property \app\models\mgcms\db\File $file
 */
class Gallery extends \app\models\mgcms\db\AbstractRecord
{


  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['name', 'slug'], 'required'],
        [['created_on'], 'safe'],
        [['created_by', 'order', 'promoted', 'file_id'], 'integer'],
        [['description'], 'string'],
        [['name', 'slug'], 'string', 'max' => 245],
        [['name'], 'unique'],
        [['slug'], 'unique'],
    ];
  }

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'gallery';
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'id' => Yii::t('app', 'ID'),
        'name' => Yii::t('app', 'Name'),
        'slug' => Yii::t('app', 'Slug'),
        'created_on' => Yii::t('app', 'Created On'),
        'order' => Yii::t('app', 'Order'),
        'description' => Yii::t('app', 'Description'),
        'promoted' => Yii::t('app', 'Promoted'),
        'uploadedFiles' => Yii::t('app', 'Images'),
        'file_id' => Yii::t('app', 'File'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCreatedBy()
  {
    return $this->hasOne(\app\models\mgcms\db\User::className(), ['id' => 'created_by']);
  }

  /**
   * @inheritdoc
   * @return \app\models\mgcms\db\GalleryQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\mgcms\db\GalleryQuery(get_called_class());
  }

  /**
   * @inheritdoc
   * @return array mixed
   */
  public function behaviors()
  {
    return [
        [
            'class' => SluggableBehavior::className(),
            'attribute' => 'name',
            'slugAttribute' => 'slug',
        ],
    ];
  }

   /**
   * @return \yii\db\ActiveQuery
   */
  public function getFile()
  {
    return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'file_id']);
  }

  public function __toString()
  {
    return $this->name;
  }

  public function getLinkUrl()
  {

    return MgHelpers::createUrl(['/gallery/view', 'slug' => $this->slug]);
  }

  public function getLink($text = false)
  {
    return \yii\helpers\Html::a(
            $text ? $text : (string) $this, \yii\helpers\Url::toRoute(['/gallery/view', 'slug' => $this->slug]),
            ['target' => '_blank', 'data-pjax' => "0"]);
  }


}
