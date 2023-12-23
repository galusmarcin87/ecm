<?php
namespace app\models\mgcms\db;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the base model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $json
 */
class Tag extends \app\models\mgcms\db\AbstractRecord
{

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['name'], 'required'],
        [['json'], 'string'],
        [['name'], 'string', 'max' => 255]
    ];
  }

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'tag';
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'id' => Yii::t('app', 'ID'),
        'name' => Yii::t('app', 'Name'),
        'json' => Yii::t('app', 'Json'),
    ];
  }

  /**
   * @inheritdoc
   * @return \app\models\mgcms\db\TagQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\mgcms\db\TagQuery(get_called_class());
  }

  public static function getTagsNamesArray()
  {
    $tags = Tag::find()->all();
    $tagNames = [];
    foreach ($tags as $tag) {
      $tagNames[] = $tag->name;
    }
    return $tagNames;
  }

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
  
  public function getLinkUrl()
  {
    return \yii\helpers\Url::to(['/article/tag', 'tagSlug' => $this->slug]);
  }

  public function getLink($text = false)
  {
    return \yii\helpers\Html::a(
            $text ? $text : (string) $this, $this->getLinkUrl(), ['target' => '_blank', 'data-pjax' => "0"]);
  }
}
