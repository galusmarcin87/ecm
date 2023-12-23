<?php

namespace app\modules\backend\controllers\mgcms;

use app\models\mgcms\db\File;
use app\models\mgcms\db\FileRelation;
use app\models\mgcms\db\User;
use Yii;
use app\models\mgcms\db\Project;
use app\models\mgcms\db\ProjectSearch;
use app\modules\backend\components\mgcms\MgBackendController;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\mgcms\MgHelpers;
use yii\web\UploadedFile;
use FiberPay\FiberPayClient;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends MgBackendController
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
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        if ($this->getUserModel()->role == User::ROLE_PROJECT_OWNER) {
            $searchModel->created_by = $this->getUserModel()->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $providerBonus = new \yii\data\ArrayDataProvider([
            'allModels' => $model->bonuses,
        ]);
        $providerPayment = new \yii\data\ArrayDataProvider([
            'allModels' => $model->payments,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'providerBonus' => $providerBonus,
            'providerPayment' => $providerPayment,
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Project();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            $fiberPayConfig = MgHelpers::getConfigParam('fiberPay');
            $fiberClient = new FiberPayClient($fiberPayConfig['apikey'], $fiberPayConfig['secretkey'], $fiberPayConfig['testServer']);
            $collect = $fiberClient->createCollect($model->pay_name, $model->iban, 'USD');

            $collectObj = Json::decode($collect);
            $code = $collectObj['data']['code'];

            $model->fiber_collect_id = $code;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $lang = false)
    {
        if (Yii::$app->request->post('_asnew') == '1') {
            $model = new Project();
        } else {
            $model = $this->findModel($id);
        }

        $model->language = $lang;

        $post = Yii::$app->request->post();
        $this->_assignPostFaqs($post);

        if ($model->loadAll($post) && $model->saveAll(['payments','faqs'])) {
            $this->_assignDownloadFiles($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    private function _assignPostFaqs(&$post)
    {
        if (isset($post['Faq'])) {
            $post['Bonus'] = array_merge($post['Bonus'], $post['Faq']);
        }
    }


    /**
     * Deletes an existing Project model.
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
     * Export Project information into PDF format.
     * @param integer $id
     * @return mixed
     */
    public function actionPdf($id)
    {
        $model = $this->findModel($id);
        $providerBonus = new \yii\data\ArrayDataProvider([
            'allModels' => $model->bonuses,
        ]);
        $providerPayment = new \yii\data\ArrayDataProvider([
            'allModels' => $model->payments,
        ]);

        $content = $this->renderAjax('_pdf', [
            'model' => $model,
            'providerBonus' => $providerBonus,
            'providerPayment' => $providerPayment,
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
     * Creates a new Project model by another data,
     * so user don't need to input all field from scratch.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param type $id
     * @return type
     */
    public function actionSaveAsNew($id)
    {
        $model = new Project();

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
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for Bonus
     * @return mixed
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     */
    public function actionAddBonus()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Bonus');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = ['to' => 1];
            return $this->renderAjax('_formBonus', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    public function actionAddFaq()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Faq');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = ['to' => 2];
            return $this->renderAjax('_formFaq', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * Action to load a tabular form grid
     * for Payment
     * @return mixed
     * @author Jiwantoro Ndaru <jiwanndaru@gmail.com>
     *
     * @author Yohanes Candrajaya <moo.tensai@gmail.com>
     */
    public function actionAddPayment()
    {
        if (Yii::$app->request->isAjax) {
            $row = Yii::$app->request->post('Payment');
            if ((Yii::$app->request->post('isNewRecord') && Yii::$app->request->post('_action') == 'load' && empty($row)) || Yii::$app->request->post('_action') == 'add')
                $row[] = [];
            return $this->renderAjax('_formPayment', ['row' => $row]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
