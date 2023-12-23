<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\mgcms\db\Faq;
use app\models\mgcms\db\FaqItem;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

class FaqController extends \app\components\mgcms\MgCmsController
{

  public function actionIndex($id)
  {
    $faq = Faq::findOne($id);
    if (!$faq) {
      \app\components\mgcms\MgHelpers::throw404();
    }

    $dataProvider = new ActiveDataProvider([
        'query' => FaqItem::find()->where(['faq_id' => $faq->id])
            ->orderBy('order ASC'),
        'pagination' => [
            'pageSize' => 1000,
        ]
    ]);

    return $this->render('index', [
            'dataProvider' => $dataProvider,
            'faq' => $faq
    ]);
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionView($id)
  {
    $model = FaqItem::findOne($id);
    \branchonline\lightbox\Lightbox::widget();
    if(!$model){
      \app\components\mgcms\MgHelpers::throw404();
    }
    return $this->render('view', ['model' => $model]);
  }
}
