<?php
namespace app\modules\backend\components\mgcms;

use app\components\mgcms\MgCmsController;
use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\File;
use app\models\mgcms\db\FileRelation;
use yii\filters\AccessControl;
use Yii;
use yii\web\UploadedFile;

/**
 * Default controller for the `backend` module
 */
class MgBackendController extends MgCmsController
{

  public function init()
  {
    parent::init();
    Yii::$app->user->loginUrl = '/backend/default/login';
    Yii::$app->homeUrl = '/admin';
  }

  public function behaviors()
  {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['login', 'signup'],
                ],
                [
                    'allow' => true,
//                    'actions' => ['login', 'signup'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
//                    'actions' => ['*'],
                    'roles' => ['*'],
                ],
            ]
        ],
    ];
  }

  public function beforeAction($action)
  {

    if ($this->getUserModel()) {
      if (!$this->getUserModel()->checkAccess(str_replace(['mgcms/'], '', Yii::$app->controller->id), Yii::$app->controller->action->id)) {
        throw new \yii\web\HttpException(403);
      }
    }
    $actionController = Yii::$app->controller->id . '/' . Yii::$app->controller->action->id;
    if (!$this->getUserModel() && !in_array($actionController, [
            'default/login',
            'default/index'
        ])) {
      $this->redirect(['/backend/default']);
      return;
    }


    return parent::beforeAction($action);
  }

  public function initEditableBehavior($className)
  {
    if (Yii::$app->request->post('hasEditable')) {
      $model = new $className;
      $reflectionModel = new \ReflectionClass($model);
      $modelFullClass = $reflectionModel->getName();
      $modelClass = $reflectionModel->getShortName();
      $model = $modelFullClass::findOne(Yii::$app->request->post('editableKey'));
      $post = [];
      $posted = current($_POST[$modelClass]);
      $post[$modelClass] = $posted;
      if ($model->load($post)) {
        if ($model->save()) {
          $out = \yii\helpers\Json::encode(['output' => $model->{Yii::$app->request->post('editableAttribute')}, 'message' => '']);
        }
      }
      echo $out;
      die;
    }
  }

    public function actionRemoveImage($id)
    {
        $model = $this->findModel($id);

        $model->file_id = null;
        $model->save();
        $this->back();
    }

    public function _assignDownloadFiles($model)
    {
        $upladedFiles = UploadedFile::getInstances($model, 'downloadFiles');

        if ($upladedFiles) {
            foreach ($upladedFiles as $CUploadedFileModel) {
                if ($CUploadedFileModel->hasError) {
                    MgHelpers::setFlash(MgHelpers::FLASH_TYPE_ERROR, Yii::t('app', 'Error with uploading file - probably file is too big'));
                    continue;
                }
                $fileModel = new File;
                $file = $fileModel->push(new \rmrevin\yii\module\File\resources\UploadedResource($CUploadedFileModel));
                if ($file) {
                    if (FileRelation::find()->where(['file_id' => $file->id, 'rel_id' => $this->id, 'model' => $this::className()])->count()) {
                        continue;
                    }
                    $fileRel = new FileRelation;
                    $fileRel->file_id = $file->id;
                    $fileRel->rel_id = $model->id;
                    $fileRel->model = $model::className();
                    $fileRel->json = 1;
                    MgHelpers::saveModelAndLog($fileRel);
                } else {
                    MgHelpers::setFlashError('Błąd dodawania pliku powiązanego');
                }
            }
            return true;
        }
        return false;
    }

    public function _assignLogosFiles($model)
    {
        $upladedFiles = UploadedFile::getInstances($model, 'logosFiles');

        if ($upladedFiles) {
            foreach ($upladedFiles as $CUploadedFileModel) {
                if ($CUploadedFileModel->hasError) {
                    MgHelpers::setFlash(MgHelpers::FLASH_TYPE_ERROR, Yii::t('app', 'Error with uploading file - probably file is too big'));
                    continue;
                }
                $fileModel = new File;
                $file = $fileModel->push(new \rmrevin\yii\module\File\resources\UploadedResource($CUploadedFileModel));
                if ($file) {
                    if (FileRelation::find()->where(['file_id' => $file->id, 'rel_id' => $this->id, 'model' => $this::className()])->count()) {
                        continue;
                    }
                    $fileRel = new FileRelation;
                    $fileRel->file_id = $file->id;
                    $fileRel->rel_id = $model->id;
                    $fileRel->model = $model::className();
                    $fileRel->json = 'logo';
                    MgHelpers::saveModelAndLog($fileRel);
                } else {
                    MgHelpers::setFlashError('Błąd dodawania pliku powiązanego');
                }
            }
            return true;
        }
        return false;
    }

}
