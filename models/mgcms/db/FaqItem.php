<?php
namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;

/**
 * This is the base model class for table "faq_item".
 *
 * @property integer $id
 * @property string $question
 * @property string $answer
 * @property integer $faq_id
 * @property integer $order
 * @property string $content
 * @property string $linkUrl
 * @property string $link
 *
 * @property \app\models\mgcms\db\Faq $faq
 */
class FaqItem extends \app\models\mgcms\db\AbstractRecord
{

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
        [['question', 'answer', 'content'], 'string'],
        [['faq_id'], 'required'],
        [['faq_id', 'order'], 'integer']
    ];
  }

  /**
   * @inheritdoc
   */
  public static function tableName()
  {
    return 'faq_item';
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels()
  {
    return [
        'id' => Yii::t('app', 'ID'),
        'question' => Yii::t('app', 'Question'),
        'answer' => Yii::t('app', 'Answer'),
        'faq_id' => Yii::t('app', 'Faq'),
        'faq' => Yii::t('app', 'Faq'),
        'order' => Yii::t('app', 'Order'),
        'content' => Yii::t('app', 'Content'),
    ];
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getFaq()
  {
    return $this->hasOne(\app\models\mgcms\db\Faq::className(), ['id' => 'faq_id']);
  }

  /**
   * @inheritdoc
   * @return \app\models\mgcms\db\FaqItemQuery the active query used by this AR class.
   */
  public static function find()
  {
    return new \app\models\mgcms\db\FaqItemQuery(get_called_class());
  }

  public function getLinkUrl()
  {
    return \yii\helpers\Url::to(['/faq/view', 'id' => $this->id]);
  }

  public function getLink($text = false)
  {
    return \yii\helpers\Html::a(
            $text ? $text : (string) $this, $this->getLinkUrl(), ['target' => '_blank', 'data-pjax' => "0"]);
  }
}
