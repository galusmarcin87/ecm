<?php

namespace app\modules\backend\controllers\mgcms;

use Yii;
use app\models\mgcms\db\User;
use app\models\mgcms\db\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\backend\components\mgcms\MgBackendController;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends MgBackendController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $lang = false)
    {
        $model = $this->findModel($id);
        $model->language = $lang;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $currentUser = $this->getUserModel();
        if (($model = User::findOne($id)) !== null) {
            if (!$currentUser->isAdmin() && $model->created_by != $currentUser->id) {
                if($currentUser->role === User::ROLE_SALES_DIRECTOR || $currentUser->role === User::ROLE_MANAGER || $currentUser->role === User::ROLE_INTERNATIONAL_DIRECTOR || $currentUser->role === User::ROLE_AGENT) {
                    if($model->created_by == $currentUser->id || $model->createdBy->created_by == $currentUser->id || $model->createdBy->createdBy->created_by == $currentUser->id){
                        return $model;
                    }
                }
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
            }
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
