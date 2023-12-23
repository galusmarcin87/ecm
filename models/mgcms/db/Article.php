<?php
namespace app\models\mgcms\db;

use Yii;
use mootensai\behaviors\UUIDBehavior;
use yii\behaviors\SluggableBehavior;
use \app\components\mgcms\MgHelpers;

/**
 * This is the base model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property string $excerpt
 * @property string $language
 * @property string $created_on
 * @property string $updated_on
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $status
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $parent_id
 * @property integer $category_id
 * @property integer $file_id
 * @property integer $order
 * @property integer $promoted
 * @property string $custom
 * @property string $type
 * @property string $link
 * @property string $linkUrl
 *
 * @property \app\models\mgcms\db\Article $parent
 * @property \app\models\mgcms\db\Article[] $articles
 * @property \app\models\mgcms\db\Category $category
 * @property \app\models\mgcms\db\File $file
 * @property \app\models\mgcms\db\User $createdBy
 * @property \app\models\mgcms\db\User $updatedBy
 * @property \app\models\mgcms\db\ArticleTag[] $articleTags
 * @property \app\models\mgcms\db\Tag[] $tags
 */
class Article extends \app\models\mgcms\db\AbstractRecord
{

  const TYPE_STANDARD = 'standard';
  const TYPE_GALLERY = 'gallery';
  const TYPE_NEWS = 'news';
  const TYPES = [
      self::TYPE_STANDARD,
      self::TYPE_NEWS,
      self::TYPE_GALLERY
  ];
  const STATUS_ACTIVE = 'active';
  const STATUS_DRAFT = 'draft';
  const STATUS_INACTIVE = 'inactive';
  const STATUSES = [
      self::STATUS_ACTIVE,
      self::STATUS_DRAFT,
      self::STATUS_INACTIVE,
  ];

  private $privateTagString;

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['content', 'excerpt', 'custom'], 'string'],
        [['title'], 'required'],
        [['created_on', 'updated_on', 'tagString'], 'safe'],
        [['created_by', 'updated_by', 'parent_id', 'category_id', 'file_id', 'order', 'promoted'], 'integer'],
        [['title', 'slug', 'type'], 'string', 'max' => 255],
        [['language'], 'string', 'max' => 10],
        [['meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 245],
        [['status'], 'string', 'max' => 45],
        [['slug'], 'unique'],
        [['title'], 'unique']
    ];
  }

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'article';
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'id' => Yii::t('app', 'ID'),
        'title' => Yii::t('app', 'Title'),
        'content' => Yii::t('app', 'Content'),
        'slug' => Yii::t('app', 'Slug'),
        'excerpt' => Yii::t('app', 'Excerpt'),
        'language' => Yii::t('app', 'Language'),
        'created_on' => Yii::t('app', 'Created On'),
        'updated_on' => Yii::t('app', 'Updated On'),
        'meta_title' => Yii::t('app', 'Meta Title'),
        'meta_description' => Yii::t('app', 'Meta Description'),
        'meta_keywords' => Yii::t('app', 'Meta Keywords'),
        'status' => Yii::t('app', 'Status'),
        'parent_id' => Yii::t('app', 'Parent'),
        'category_id' => Yii::t('app', 'Category'),
        'file_id' => Yii::t('app', 'File'),
        'order' => Yii::t('app', 'Order'),
        'promoted' => Yii::t('app', 'Promoted'),
        'custom' => Yii::t('app', 'Custom'),
        'type' => Yii::t('app', 'Type'),
        'tagString' => Yii::t('app', 'Tags'),
        'uploadedFiles' => Yii::t('app', 'Images'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getParent()
  {
    return $this->hasOne(\app\models\mgcms\db\Article::className(), ['id' => 'parent_id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getArticles()
  {
    return $this->hasMany(\app\models\mgcms\db\Article::className(), ['parent_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getCategory()
  {
    return $this->hasOne(\app\models\mgcms\db\Category::className(), ['id' => 'category_id']);
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
  public function getCreatedBy()
  {
    return $this->hasOne(\app\models\mgcms\db\User::className(), ['id' => 'created_by']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getUpdatedBy()
  {
    return $this->hasOne(\app\models\mgcms\db\User::className(), ['id' => 'updated_by']);
  }

  public function getTags()
  {
    return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getArticleTags()
  {
    return $this->hasMany(\app\models\mgcms\db\ArticleTag::className(), ['article_id' => 'id']);
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
            'attribute' => 'title',
            'slugAttribute' => 'slug',
            'immutable' => true
        ],
    ];
  }

  /**
   * @inheritdoc
   * @return \app\models\mgcms\db\ArticleQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\mgcms\db\ArticleQuery(get_called_class());
  }

  public function getLinkUrl()
  {
    return \yii\helpers\Url::to(['/article/view', 'slug' => $this->slug, 'categorySlug' => $this->category ? $this->category->getUrl() : null]);
  }

  public function getLink($text = false)
  {
    return \yii\helpers\Html::a(
            $text ? $text : (string) $this, $this->getLinkUrl(), ['target' => '_blank', 'data-pjax' => "0"]);
  }

  public function __toString()
  {
    return $this->title;
  }

  public function getTagString()
  {
    $tagNamesArr = [];
    foreach ($this->tags as $tag) {
      $tagNamesArr[] = $tag->name;
    }
    return implode(',', $tagNamesArr);
  }

  public function setTagString($value)
  {
    $this->privateTagString = $value;
  }

  public function setTags()
  {
    $deleteRelated = ArticleTag::deleteAll("article_id =  $this->id");
    if ($this->privateTagString) {
      $tagsNamesArray = array_map('trim', explode(',', $this->privateTagString));
      foreach ($tagsNamesArray as $tagName) {
        $tag = Tag::find()->where(['name' => $tagName])->one();
        if (!$tag) {
          $tag = new Tag;
          $tag->name = $tagName;
          $tag->save();
        }
        $articleTag = new ArticleTag;
        $articleTag->tag_id = $tag->id;
        $articleTag->article_id = $this->id;
        $saved = $articleTag->save();
      }
    }
  }
}
