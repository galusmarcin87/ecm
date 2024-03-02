<?php

namespace app\components\mgcms;

use Yii;

class T
{

  static function bt($str, $fromDatabase = false)
  {
    return self::translate('backend', $str, $fromDatabase);
  }

  static function t($str)
  {
    return Yii::t('app', $str, array());
  }

  static function translate($category, $str, $fromDatabase = false, $insertIfFromDatabase = true)
  {
    if ($fromDatabase) {
      $translated = Yii::t($category, $str, array(), 'messages');
      if ($translated == $str) {

        if (!self::getInstance()->checkTranslation($str, $category)) {
          if ($insertIfFromDatabase) {
            $i18nSourcemessage = new I18nSourcemessage;
            $i18nSourcemessage->message = $str;
            $i18nSourcemessage->category = $category;
            $i18nSourcemessage->save();

            self::getInstance()->refreshTranslations();
          } else {
            return Yii::t($category, $str, array(), 'messagesPhp');
          }
        }
        return Yii::t($category, $str, array(), 'messagesPhp');
      }
      return $translated;
    }
    return Yii::t($category, $str, array(), 'messagesPhp');
  }

  static function sbt($str)
  {
    return Yii::t('solano_backend', $str, array(), 'messagesPhp');
  }

  static function sft($str, $fromDatabase = true, $insertIfFromDatabase = true)
  {
    return self::translate('solano_frontend', $str, $fromDatabase, $insertIfFromDatabase);
  }

  /**
   * The singleton instance
   * @var T
   */
  private static $_instance;
  private $translations;

  /**
   * Instance of the class (singleton pattern)
   * @return T
   */
  public static function getInstance()
  {
    if (!self::$_instance) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct()
  {
    $this->refreshTranslations();
  }

  public function refreshTranslations()
  {
    $this->translations = I18nSourcemessage::model()->findAll();
  }

  protected function checkTranslation($message, $category)
  {
    foreach ($this->translations as $translation) {
      /* @var $translation I18nSourcemessage */
      if ($translation->message == $message && $translation->category == $category) {
        return true;
      }
    }

    return false;
  }

  /**
   * translate coma separated values
   * @param type $str
   * @param type $fromDatabase
   * @return type
   */
  static function sftcs($str, $fromDatabase = true)
  {
    $arr = explode(',', $str);
    $retArr = array();
    foreach ($arr as $el) {
      $retArr[] = self::translate('solano_frontend', trim($el), $fromDatabase);
    }

    return implode(',', $retArr);
  }
}
