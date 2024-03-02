<?php
namespace app\models\mgcms\db;

use \app\models\mgcms\db\base\I18nSourceMessage as BaseI18nSourceMessage;
use app\components\mgcms\MgHelpers;

/**
 * This is the model class for table "i18n_source_message".
 */
class I18nSourceMessage extends BaseI18nSourceMessage
{

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return array_replace_recursive(parent::rules(), [
        [['message'], 'string'],
        [['category'], 'string', 'max' => 255],
    ]);
  }

  public function getTranslateLinks()
  {
    $html = '';
    if (!is_array(\Yii::$app->i18n->languages)) {
      MgHelpers::setFlash('error', "supported_languages config param missed");
      return false;
    }
    foreach (\Yii::$app->i18n->languages as $lang) {
      $html .= \yii\helpers\Html::a($lang, \Yii::$app->urlManager->createUrl(
                  [
                      'backend/mgcms/translate/translation',
                      'lang' => $lang,
                      'id' => $this->id
              ]), array('class' => 'btn btn-primary'));
    }

    return $html;
  }
}
