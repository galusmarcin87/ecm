<?php
namespace app\modules\backend\controllers\mgcms;

use Yii;
use app\models\mgcms\db\File;
use yii\data\ActiveDataProvider;
use app\modules\backend\components\mgcms\MgBackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use rmrevin\yii\module\File\resources\UploadedResource;
use app\models\mgcms\db\FileSearch;
use app\components\mgcms\MgHelpers;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends MgBackendController
{

  public $enableCsrfValidation = false;

  public function behaviors()
  {
    return [
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
//                'delete' => ['post'],
            ],
        ],
    ];
  }

  /**
   * Lists all File models.
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new FileSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]);
  }

  public function actionChooseFile()
  {
    $searchModel = new FileSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $this->layout = 'empty';
    return $this->render('chooseFile', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single File model.
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
   * Creates a new File model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
   public function actionCreate($emptyLayout = false)
  {
    if ($emptyLayout) {
      $this->layout = 'empty';
    }
    $model = new File();

    if ($model->load(Yii::$app->request->post())) {
      $files = UploadedFile::getInstances($model, 'name');
      foreach ($files as $file) {
        if ($file && !$file->hasError) {
          $model = $model->push(new UploadedResource($file));
          $model->created_by = $this->getUserModel()->id;
          $model->save();
        } else {
//            echo '<pre>';
//            echo var_dump($file->error);
//            echo '</pre>';
//            exit();
          MgHelpers::setFlash(MgHelpers::FLASH_TYPE_WARNING, Yii::t('app', 'Problem with uploading file') . ' ' . (string) $file);
        }
      }
      return $this->redirect($emptyLayout ? ['choose-file'] : ['index']);
    }
    return $this->render('create', [
            'model' => $model,
    ]);
  }

  /**
   * Updates an existing File model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   */
  public function actionUpdate($id)
  {
    throw new \yii\web\NotFoundHttpException();
    $model = $this->findModel($id);

    if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
              'model' => $model,
      ]);
    }
  }

  /**
   * Deletes an existing File model.
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
   * Finds the File model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return File the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = File::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
  }

  public function beforeAction($action)
  {
//      \vendor\rmrevin\yii\module\File\component\Image::$thumbnailBackgroundAlpha = 0;
    return parent::beforeAction($action);
  }

  public function actionUploadinstorage()
  {

    $file = UploadedFile::getInstanceByName('file');
    $name = uniqid() . $file->name;
    $path = \app\components\mgcms\MgHelpers::getWebRoot() . '/storage/files/' . $name;

    if(!is_dir(\app\components\mgcms\MgHelpers::getWebRoot() . '/storage/files/')){
        if (!mkdir($concurrentDirectory = \app\components\mgcms\MgHelpers::getWebRoot() . '/storage/files/') && !is_dir($concurrentDirectory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
    }


    if ($file->saveAs($path)) {
      return \yii\helpers\Json::encode(['location' => \app\components\mgcms\MgHelpers::createUrl(['/storage/files/' . $name])]);
    } else {
      return \yii\helpers\Json::encode(['error' => 'Błąd']);
    }
  }

  public function actionDeleteRelation($relId, $fileId, $model)
  {
    $fileRel = \app\models\mgcms\db\FileRelation::find()->where(['rel_id' => $relId, 'file_id' => $fileId, 'model' => $model])->one();
    if ($fileRel) {
      $fileRel->delete();
    }
    $this->back();
  }
}
