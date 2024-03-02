<?php
namespace app\modules\backend\controllers\mgcms;

use Yii;
use app\models\mgcms\db\TeamMember;
use app\models\mgcms\db\TeamMemberSearch;
use app\components\mgcms\MgCmsController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\mgcms\MgHelpers;

/**
 * TeamMemberController implements the CRUD actions for TeamMember model.
 */
class TeamMemberController extends MgCmsController
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
   * Lists all TeamMember models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new TeamMemberSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single TeamMember model.
   * @param integer $id
   * @return mixed
   */
  public function actionView($id)
  {
    $model = $this->findModel($id);
    return $this->render('view', [
            'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new TeamMember model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new TeamMember();

    if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('create', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Updates an existing TeamMember model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id, $lang = false)
  {
    if (Yii::$app->request->post('_asnew') == '1') {
      $model = new TeamMember();
    } else {
      $model = $this->findModel($id);
    }
    $model->language = $lang;
    if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Deletes an existing TeamMember model.
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
   * 
   * Export TeamMember information into PDF format.
   * @param integer $id
   * @return mixed
   */
  public function actionPdf($id)
  {
    $model = $this->findModel($id);

    $content = $this->renderAjax('_pdf', [
        'model' => $model,
    ]);

    $pdf = new \kartik\mpdf\Pdf([
        'mode' => \kartik\mpdf\Pdf::MODE_UTF8,
        'format' => \kartik\mpdf\Pdf::FORMAT_A4,
        'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
        'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
        'content' => $content,
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        'cssInline' => '.kv-heading-1{font-size:18px}',
        'options' => ['title' => \Yii::$app->name],
        'methods' => [
            'SetHeader' => [\Yii::$app->name],
            'SetFooter' => ['{PAGENO}'],
        ]
    ]);

    return $pdf->render();
  }

  /**
   * Creates a new TeamMember model by another data,
   * so user don't need to input all field from scratch.
   * If creation is successful, the browser will be redirected to the 'view' page.
   *
   * @param type $id
   * @return type
   */
  public function actionSaveAsNew($id)
  {
    $model = new TeamMember();

    if (Yii::$app->request->post('_asnew') != '1') {
      $model = $this->findModel($id);
    }

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('saveAsNew', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Finds the TeamMember model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return TeamMember the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = TeamMember::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
  }
}
