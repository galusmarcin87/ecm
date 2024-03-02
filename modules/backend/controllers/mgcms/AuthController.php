<?php
namespace app\modules\backend\controllers\mgcms;

use Yii;
use app\models\mgcms\db\Auth;
use app\models\mgcms\db\AuthSearch;
use app\modules\backend\components\mgcms\MgBackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\mgcms\MgHelpers;

/**
 * AuthController implements the CRUD actions for Auth model.
 */
class AuthController extends MgBackendController
{

  /**
   * @inheritdoc
   */
  public function behaviors()
  {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ],
    ];
  }

  /**
   * Lists all Auth models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new AuthSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Auth model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    return $this->render('view', [
            'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Auth model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Auth();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('create', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Updates an existing Auth model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Deletes an existing Auth model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Auth model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Auth the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Auth::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

  /**
   * Manages all models.
   */
  public function actionManage()
  {
    ini_set('max_execution_time', 3000);
    if (isset($_POST['auth'])) {

      $transaction = Yii::$app->db->beginTransaction();
      try {
        Yii::$app->db->createCommand()->truncateTable('auth')->execute();
        foreach ($_POST['auth'] as $controller => $actionRole) {
          foreach ($actionRole as $action => $roles) {
            foreach ($roles as $role => $value) {
              if ($value) {
                $auth = new Auth;
                $auth->controller = $controller;
                $auth->action = $action;
                $auth->role = $role;
                $auth->value = 1;
                $auth->save();
              }
            }
          }
        }
        $transaction->commit();
        MgHelpers::setFlashSuccess('Zapisano');
        $this->refresh();
      } catch (\Exception $e) {
        $transaction->rollBack();
        throw $e;
      } catch (\Throwable $e) {
        $transaction->rollBack();
        throw $e;
      }
    }

    $auths = Auth::find()->groupBy('controller,action')->orderBy('controller ASC, action ASC')->all();

    return $this->render('manage', array(
            'auths' => $auths,
    ));
  }
}
