<?php
namespace app\components\mgcms;

use Yii;
use yii\base\Component;
use yii\base\Widget;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use yii\web\Cookie;

class languageSwitcher extends Widget
{

  public function init()
  {
    if (php_sapi_name() === 'cli') {
      return true;
    }
    parent::init();

    $cookies = Yii::$app->response->cookies;


    $languageNew = Yii::$app->request->get('language');
    $languages = self::getLanguages();

    if ($languageNew) {
      if (isset($languages[$languageNew])) {

        Yii::$app->language = $languageNew;

        $cookie = new Cookie([
            'name' => 'language',
            'value' => $languageNew,
            'httpOnly' => true,
        ]);
        \Yii::$app->getResponse()->getCookies()->add($cookie);
      }
    } elseif (\Yii::$app->getRequest()->getCookies()->has('language')) {
      Yii::$app->language = \Yii::$app->getRequest()->getCookies()->getValue('language');
    }
  }

  public static function getMenuItems()
  {
    $languages = self::getLanguages();
    if (sizeof($languages) <= 1) {
      return false;
    }
    $current = $languages[Yii::$app->language];
    unset($languages[Yii::$app->language]);

    $items = [];
    foreach ($languages as $code => $language) {
      $temp = [];
      $temp['label'] = $language;
      $temp['url'] = Url::to(['/','language' => $code]);
      array_push($items, $temp);
    }


    return ['label' => strtoupper(Yii::$app->language), 'url' => '#', 'items' => $items];
  }

  public static function getLanguages()
  {
    $arr = [];
    foreach (Yii::$app->params['languages'] as $language) {
      $arr[$language] = strtoupper($language);
    }
    return $arr;
  }

  public function run()
  {
    $languages = $this->languages;
    $current = $languages[Yii::$app->language];
    echo ButtonDropdown::widget([
        'label' => $current,
        'dropdown' => [
            'items' => self::getMenuItems()['items'],
        ],
    ]);
  }
}
