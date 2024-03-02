<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;

/**
 * This is the base model class for table "faq".
 *
 * @property integer $id
 * @property string $name
 * @property string $lang
 * @property integer $type
 * @property string $content
 * @property string $linkUrl
 * @property string $link
 *
 * @property \app\models\mgcms\db\FaqItem[] $faqItems
 */
class Faq extends \app\models\mgcms\db\AbstractRecord
{

    const TYPE_FAQ = 1;
    const TYPES = [
        self::TYPE_FAQ => 'FAQ'
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 245],
            [['lang'], 'string', 'max' => 5],
            [['content'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'lang' => Yii::t('app', 'Language'),
            'type' => Yii::t('app', 'Type'),
            'typeStr' => Yii::t('app', 'Type'),
            'content' => Yii::t('app', 'Content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaqItems()
    {
        $res = $this->hasMany(\app\models\mgcms\db\FaqItem::className(), ['faq_id' => 'id'])->orderBy(['order' => SORT_ASC]);
        return $res;
    }

    /**
     *
     * @param integer $limit
     * @return FaqItem[]
     */
    public function getTopFaqItems($limit = 3)
    {
        $res = $this->hasMany(\app\models\mgcms\db\FaqItem::className(), ['faq_id' => 'id'])->orderBy(['order' => SORT_ASC])->limit($limit)->all();
        return $res;
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\FaqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\FaqQuery(get_called_class());
    }

    public function getTypeStr()
    {
        return self::TYPES[$this->type];
    }

    public function getLinkUrl()
    {
        return \yii\helpers\Url::to(['/faq/index', 'id' => $this->id]);
    }

    public function getLink($text = false)
    {
        return \yii\helpers\Html::a(
            $text ? $text : (string)$this, $this->getLinkUrl(), ['target' => '_blank', 'data-pjax' => "0"]);
    }
}
