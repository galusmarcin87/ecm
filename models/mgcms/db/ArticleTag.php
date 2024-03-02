<?php

namespace app\models\mgcms\db;

use Yii;

/**
 * This is the base model class for table "article_tag".
 *
 * @property integer $article_id
 * @property integer $tag_id
 *
 * @property \app\models\mgcms\db\Article $article
 * @property \app\models\mgcms\db\Tag $tag
 */
class ArticleTag extends \app\models\mgcms\db\AbstractRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => Yii::t('app', 'Article ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(\app\models\mgcms\db\Article::className(), ['id' => 'article_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(\app\models\mgcms\db\Tag::className(), ['id' => 'tag_id']);
    }
    
    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\ArticleTagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\ArticleTagQuery(get_called_class());
    }
}
