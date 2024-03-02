<?php

namespace app\modules\backend\controllers\mgcms;

use app\models\mgcms\db\File;
use app\models\mgcms\db\FileRelation;
use app\models\mgcms\db\User;
use Yii;
use app\models\mgcms\db\Company;
use app\models\mgcms\db\CompanySearch;
use app\modules\backend\components\mgcms\MgBackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\mgcms\MgHelpers;
use yii\web\UploadedFile;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends MgBackendController
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
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        if(!MgHelpers::isAdmin()){
            $searchModel->agentCode = $this->getUserModel()->agent_code;
            $searchModel->created_by = $this->getUserModel()->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerAgent = new \yii\data\ArrayDataProvider([
            'allModels' => $model->agents,
        ]);
        $providerBenefit = new \yii\data\ArrayDataProvider([
            'allModels' => $model->benefits,
        ]);
        $providerJob = new \yii\data\ArrayDataProvider([
            'allModels' => $model->jobs,
        ]);
        $providerProduct = new \yii\data\ArrayDataProvider([
            'allModels' => $model->products,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerAgent' => $providerAgent,
            'providerBenefit' => $providerBenefit,
            'providerJob' => $providerJob,
            'providerProduct' => $providerProduct,
        ]);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();
        if(!MgHelpers::isAdmin()){
            $model->user_id = $this->getUserModel()->id;
        }

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            $this->_assignDownloadFiles($model);
            $this->_assignLogosFiles($model);
            MgHelpers::setFlash('success', Yii::t('db', 'Saved'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $lang = false)
    {
        $model = $this->findModel($id);
        $model->language = $lang;
        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll(['institutionCompanies'])) {
            $this->_assignDownloadFiles($model);
            $this->_assignLogosFiles($model);
            $this->_assignAgentsToCompany($model);
            MgHelpers::setFlash('success', Yii::t('db', 'Saved'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param Company $model
     */
    private function _assignAgentsToCompany($model)
    {
        foreach ($model->agents as $agent) {
            $user = User::find()->where(['id' => $agent->user_id])->one();
            $user->company_id = (string)$model->id;
            $user->save();

        }
    }


    /**
     * Deletes an existing Company model.
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
     * Export Company information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id)
    {
        $model = $this->findModel($id);
        $providerAgent = new \yii\data\ArrayDataProvider([
            'allModels' => $model->agents,
        ]);
        $providerBenefit = new \yii\data\ArrayDataProvider([
            'allModels' => $model->benefits,
        ]);
        $providerJob = new \yii\data\ArrayDataProvider([
            'allModels' => $model->jobs,
        ]);
        $providerProduct = new \yii\data\ArrayDataProvider([
            'allModels' => $model->products,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerAgent' => $providerAgent,
            'providerBenefit' => $providerBenefit,
            'providerJob' => $providerJob,
            'providerProduct' => $providerProduct,
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
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $currentUser = $this->getUserModel();
        if (($model = Company::findOne($id)) !== null) {
            if (!$currentUser->isAdmin() && $model->user_id != $currentUser->id) {
                if($currentUser->role === User::ROLE_SALES_DIRECTOR || $currentUser->role === User::ROLE_MANAGER || $currentUser->role === User::ROLE_INTERNATIONAL_DIRECTOR || $currentUser->role === User::ROLE_AGENT) {
                    //my or my agents companies


                    if($model->created_by == $currentUser->id || $model->agent_code == $currentUser->agent_code || $model->createdBy->created_by == $currentUser->id || $model->createdBy->agent_code == $currentUser->agent_code) {
                        return $model;
                    }
                    // my managers companies
                    if($model->createdBy->createdBy && ($model->createdBy->createdBy->created_by == $currentUser->id || $model->createdBy->createdBy->agent_code == $currentUser->agent_code)){
                        return $model;
                    }
                    // my sales director companies
                    if($model->createdBy->created_by && $model->createdBy->createdBy->created_by && ($model->createdBy->createdBy->createdBy->created_by == $currentUser->id || $model->createdBy->createdBy->createdBy->agent_code == $currentUser->agent_code)){
                        return $model;
                    }

                    // my international director companies
                    if($model->createdBy->created_by && $model->createdBy->createdBy->created_by && $model->createdBy->createdBy->createdBy->created_by && ($model->createdBy->createdBy->createdBy->createdBy->created_by == $currentUser->id || $model->createdBy->createdBy->createdBy->createdBy->agent_code == $currentUser->agent_code)){
                        return $model;
                    }
                }
                throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
            }
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for Agent
     * @return mixed
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     */
    public function actionAddAgent()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Agent');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formAgent', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for Benefit
     * @return mixed
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     */
    public function actionAddBenefit()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Benefit');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formBenefit', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for Job
     * @return mixed
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     */
    public function actionAddJob()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Job');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formJob', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for Product
     * @return mixed
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     */
    public function actionAddProduct()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Product');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formProduct', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for Product
     * @return mixed
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     */
    public function actionAddService()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Service');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formService', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
