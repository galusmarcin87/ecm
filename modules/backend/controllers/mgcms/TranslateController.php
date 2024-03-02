<?php
namespace app\modules\backend\controllers\mgcms;

use Yii;
use app\models\mgcms\db\I18nSourceMessage;
use app\models\mgcms\db\I18nMessage;
use app\models\mgcms\db\I18nSourceMessageSearch;
use app\modules\backend\components\mgcms\MgBackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * I18nSourceMessageController implements the CRUD actions for I18nSourceMessage model.
 */
class TranslateController extends MgBackendController
{

  public function behaviors()
  {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['post'],
            ],
        ],
    ];
  }

  /**
   * Lists all I18nSourceMessage models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new I18nSourceMessageSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single I18nSourceMessage model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    $model = $this->findModel($id);
    $providerI18nMessage = new \yii\data\ArrayDataProvider([
        'allModels' => $model->i18nMessages,
    ]);
    return $this->render('view', [
            'model' => $this->findModel($id),
            'providerI18nMessage' => $providerI18nMessage,
    ]);
  }

  /**
   * Creates a new I18nSourceMessage model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new I18nSourceMessage();

    if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
      Yii::$app->cache->flush();
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('create', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Updates an existing I18nSourceMessage model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
      Yii::$app->cache->flush();
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Deletes an existing I18nSourceMessage model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->deleteWithRelated();

    return $this->redirect(['index']);
  }

  /**
   * Finds the I18nSourceMessage model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return I18nSourceMessage the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = I18nSourceMessage::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
  }

  /**
   * Action to load a tabular form grid
   * for I18nMessage
   * @author Yohanes Candrajaya <moo.tensai@gmail.com>
   * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
   *
   * @return mixed
   */
  public function actionAddI18nMessage()
  {
    if (Yii::$app->request->isAjax) {
      $row = Yii::$app->request->post('I18nMessage');
      if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
        $row[] = [];
      return $this->renderAjax('_formI18nMessage', ['row' => $row]);
    } else {
      throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
  }

  public function actionTranslation($lang, $id)
  {
    $model = I18nMessage::find()->where(['language' => $lang, 'id' => $id])->one();

    if (!$model)
      $model = new I18nMessage();

    $model->language = $lang;
    $model->id = $id;
    
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    } else {
      return $this->render('updateMessage', [
              'model' => $model,
              'lang' => $lang,
      ]);
    }
  }
}
