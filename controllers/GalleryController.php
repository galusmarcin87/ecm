<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\mgcms\db\Gallery;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class GalleryController extends \app\components\mgcms\MgCmsController
{

  public function actionIndex()
  {

    $dataProvider = new ActiveDataProvider([
        'query' => Gallery::find()->orderBy('`order` ASC'),
    ]);

    return $this->render('index', [
            'dataProvider' => $dataProvider
    ]);
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionView($slug)
  {
    $model = Gallery::find()->where(['slug' => $slug])->one();
    if (!$model) {
      throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
    }

    /* -----------  SEO  ------------ */
    Yii::$app->view->title =  $model->name;
    /* -----------  SEO  ------------ */


    return $this->render('view', ['model' => $model]);
  }
}
