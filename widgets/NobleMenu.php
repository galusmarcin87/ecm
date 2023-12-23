<?php
namespace app\widgets;

use Yii;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use \app\models\mgcms\db\Menu;
use \app\models\mgcms\db\MenuItem;

class NobleMenu extends MgMenu
{

  public $brandLabel;
  public $name;
  public $loginLink = true;
  public $langVersions = false;
  private $menuModel;

  /**
   * {@inheritdoc}
   */
  public function run()
  {
    if (!$this->name) {
      return false;
    }

    $this->menuModel = Menu::findOne(['name' => $this->name]);
    if (!$this->menuModel) {
      return false;
    }

    NavBar::begin([
        'brandLabel' => $this->brandLabel,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $this->getItems(),
    ]);
    NavBar::end();
  }

  public function getItems()
  {
    if (!$this->menuModel) {
      $this->menuModel = Menu::findOne(['name' => $this->name]);
    }

    if (!$this->menuModel) {
      return [];
    }
    $arr = [];

    foreach ($this->menuModel->children as $item) {
      $menuItems = $this->getMenuItems($item);
      if ($menuItems) {
        $arr[] = $menuItems;
      }
    }

    if (\app\components\mgcms\languageSwitcher::getMenuItems() && $this->langVersions) {
      $arr[] = \app\components\mgcms\languageSwitcher::getMenuItems();
    }

    if ($this->loginLink) {
      $arr[] = Yii::$app->user->isGuest ? (
          ['label' => Yii::t('app', 'Log in'), 'url' => ['/site/login']]
          ) : (
          '<li>'
          . Html::beginForm(['/site/logout'], 'post')
          . Html::submitButton(
              Yii::t('app', 'Log out') . ' (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
          )
          . Html::endForm()
          . '</li>'
          );
    }
    return $arr;
  }

  /**
   * 
   * @param MenuItem $menuItem
   */
  public function getMenuItems($menuItem)
  {
    $ret = false;
    if ($menuItem->article) {
      $article = \app\models\mgcms\db\Article::findOne($menuItem->article_id);
      $ret['label'] = $menuItem->article->title;
      $ret['url'] = $menuItem->article->linkUrl;
      $ret['active'] = \app\components\mgcms\MgHelpers::getCurrentUrlPath() == $menuItem->article->linkUrl;
    } elseif ($menuItem->category) {
      $ret['label'] = $menuItem->category->name;
      $ret['url'] = $menuItem->category->url;
      $ret['active'] = \app\components\mgcms\MgHelpers::getCurrentUrlPath() == $menuItem->category->url;
    } else {
      $ret['label'] = $menuItem->label;
      $ret['url'] = $menuItem->url;
      $ret['active'] = \app\components\mgcms\MgHelpers::getCurrentUrlPath() == str_replace('#', '', $menuItem->url);
    }

    if ($menuItem->children && isset($ret['url'])) {
      foreach ($menuItem->children as $item) {
        $menuItems = $this->getMenuItems($item);
        if ($menuItems) {
          $ret['items'][] = $menuItems;
        }
      }
    }


    return $ret;
  }
}
