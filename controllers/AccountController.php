<?php

namespace app\controllers;

use app\components\mgcms\yii\ActiveForm;
use app\models\BuyForm;
use app\models\LoginCodeForm;
use app\models\mgcms\db\Agent;
use app\models\mgcms\db\Company;
use app\models\mgcms\db\FileRelation;
use app\models\mgcms\db\Job;
use app\models\mgcms\db\Product;
use app\models\mgcms\db\Service;
use app\models\PaySubscriptionForm;
use FiberPay\FiberIdClient;
use app\models\mgcms\db\File;
use app\models\ReportRealEstateForm;
use FiberPay\FiberPayClient;
use Web3\Methods\Eth\Accounts;
use Web3\Providers\HttpProvider;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegisterForm;
use \app\models\mgcms\db\User;
use \app\components\mgcms\MgHelpers;
use \app\models\mgcms\db\Payment;
use app\components\GetResponse\GetResponse;
use app\components\GetResponse\jsonRPCClient;
use yii\web\UploadedFile;
use app\models\mgcms\db\Article;
use Web3\Web3;
use React\Async;
use React\Promise;

class AccountController extends \app\components\mgcms\MgCmsController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($tab = 'main')
    {

        $model = $this->getUserModel();
        $model->scenario = 'account';

        if (Yii::$app->request->post('User')) {
            if (null !== Yii::$app->request->post('passwordChanging')) {
                $model->scenario = 'passwordChanging';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $upladedFile = UploadedFile::getInstance($model, 'fileUpload');
                if($upladedFile){
                    $fileModel = new File;
                    $file = $fileModel->push(new \rmrevin\yii\module\File\resources\UploadedResource($upladedFile));
                    if ($file) {
                        $model->file_id = $file->id;
                        $model->save();
                    }
                }

                MgHelpers::setFlashSuccess(Yii::t('db', 'Saved succesfully'));
            }
        }
        return $this->render('index', [
            'tab' => $tab,
            'model' => $model,
        ]);
    }


    public function actionDeleteRelation($relId, $fileId, $model)
    {
        $file = File::find()->andWhere(['id' => $fileId, 'created_by' => $this->getUserModel()->id])->one();
        $fileRel = \app\models\mgcms\db\FileRelation::find()->where(['rel_id' => $relId, 'file_id' => $fileId, 'model' => $model])->one();
        if ($fileRel) {
            $fileRel->delete();
            MgHelpers::setFlash('success', Yii::t('db', 'Deleted'));
        }
        $this->back();
    }

    public function _assignFiles($model, $type = 'downloadFiles', $json = '1')
    {
        $upladedFiles = UploadedFile::getInstances($model, $type);

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
                    $fileRel->json = $json;
                    MgHelpers::saveModelAndLog($fileRel);
                } else {
                    MgHelpers::setFlashError('Błąd dodawania pliku powiązanego');
                }
            }
            return true;
        }
        return false;
    }


    public function actionBuy($hash)
    {
        $user = $this->getUserModel();
        if (!$user) {
            MgHelpers::setFlashError(Yii::t('db', 'Log in first'));
            return $this->redirect(['site/login']);
        }
        $modelCompany = $this->_getMyCompany();
        if (!$modelCompany) {
            MgHelpers::setFlashError(Yii::t('db', 'You need to create company first in order to buy'));
            return $this->back();
        }

        if ($modelCompany->status != Company::STATUS_CONFIRMED) {
            MgHelpers::setFlashError(Yii::t('db', 'Your company has to be confirmed in order to buy'));
            return $this->back();
        }


        $data = unserialize(MgHelpers::decrypt($hash));
        $type = $data['type'];
        $id = $data['id'];


        switch ($type) {
            case 'Product':
                $model = Product::findOne($id);
                break;
            case 'Service':
                $model = Service::findOne($id);
                break;

            default:
                $model = null;
        }

        if (!$model) {
            MgHelpers::setFlashError(Yii::t('db', 'Problem with fecthing product'));
            return $this->back();
        }

        $price = (double)str_replace(',', '.', $model->price);

        if (!$price) {
            MgHelpers::setFlashError(Yii::t('db', 'Price is incorrect'));
            return $this->back();
        }

        if (!$model->company->getModelAttribute('stripeId')) {
            MgHelpers::setFlashError(Yii::t('db', 'Company you would like to buy from are not connected with Stripe'));
            return $this->back();
        }


        $apiKey = MgHelpers::getSetting('stripe api key', false, 'sk_test_51FOmrVInHv9lYN6G23xLhzLTDNytsH8bOStCMPJ472ZAoutfeNag8DSuQswJkDmkpGPd1yRqqKtFfrrSb2ReZhtM00J3jbGTp0');
        $stripe = new \Stripe\StripeClient($apiKey);

        $buyForm = new BuyForm();

        if ($buyForm->load(Yii::$app->request->post()) && $buyForm->validate()) {
            try {
                $amount = (double)((double)$buyForm->amount * (double)$model->price);
                $application_fee = (double)MgHelpers::getSetting('stripe prowizja procent', false, 5);
                $payment_intent = $stripe->paymentIntents->create([
                    'amount' => (int)($amount * 100),
                    'currency' => 'USD',
                    'automatic_payment_methods' => ['enabled' => true],
                    'application_fee_amount' => (int)$application_fee * $price,
                ], ['stripe_account' => $model->company->getModelAttribute('stripeId')]);

                return $this->render('buy', [
                    'clientSecret' => $payment_intent['client_secret'],
                    'stripeAccount' => $model->company->getModelAttribute('stripeId'),
                    'returnUrl' => Url::to(['account/buy-after', 'type' => 'success', 'hash' => MgHelpers::encrypt(serialize([
                        'company_id' => $modelCompany->id,
                        'amount' => $amount,
                        'rel_id' => $model->id,
                        'type' => $type,
                        'user_id' => $this->getUserModel()->id,
                    ]))], true),
                ]);
            } catch (Exception $e) {

                MgHelpers::setFlashError(Yii::t('db', $e));
                return $this->back();
            }
        }

        return $this->render('buyForm', ['model' => $model, 'buyForm' => $buyForm]);


    }

    public function actionConnectWithStripe()
    {
        return $this->redirect($this->generateStripeAccountLink());
    }

    public function generateStripeAccountLink()
    {
        $user = MgHelpers::getUserModel();
        if(!$user){
            return $this->redirect(['/site/logi']);
        }

        $apiKey = MgHelpers::getSetting('stripe api key', false, 'sk_test_51FOmrVInHv9lYN6G23xLhzLTDNytsH8bOStCMPJ472ZAoutfeNag8DSuQswJkDmkpGPd1yRqqKtFfrrSb2ReZhtM00J3jbGTp0');
        $stripe = new \Stripe\StripeClient($apiKey);
        $account = $stripe->accounts->create([
            'type' => 'standard',
            'country' => 'PL',
            'business_type' => 'company',
            'email' => $user->email ?: $user->username,
        ]);
        if (!$account['id']) {
            MgHelpers::setFlashError(Yii::t('db', 'Stripe: problem with creating account'));
            return $this->back();
        }

        $createParams = [
            'account' => $account['id'],
            'refresh_url' => Url::to(['/account/connect-stripe-account', 'hash' => MgHelpers::encrypt(serialize([
                    'userId' => $user->id,
                    'accountId' => $account['id']
                ]
            ))], true),
            'return_url' => Url::to(['/account/connect-stripe-account', 'hash' => MgHelpers::encrypt(serialize([
                    'userId' => $user->id,
                    'accountId' => $account['id']
                ]
            ))], true),
            'type' => 'account_onboarding',
        ];
        $accountLink = $stripe->accountLinks->create($createParams);

        return $accountLink['url'];
    }

    public function actionConnectStripeAccount($hash)
    {


        $data = unserialize(MgHelpers::decrypt($hash));
        if (!isset($data['userId']) || !isset($data['accountId'])) {
            MgHelpers::setFlashError(Yii::t('db', 'Stripe: problem with assigning stripe account'));
            return $this->redirect('/account/index');
        }

        $user = User::findOne($data['userId']);
        if (!$user) {
            MgHelpers::setFlashError(Yii::t('db', 'Stripe: problem with assigning stripe account - account not found'));
            return $this->redirect('/account/index');
        }
        $user->setModelAttribute('stripeId', $data['accountId']);
        MgHelpers::setFlashSuccess(Yii::t('db', 'Stripe: successfully connected to stripe account, you can purchase now'));
        return $this->redirect('/account/index');
    }

    public function actionVerifyByVeriff(){
        return $this->render('verifyByVeriff', []);
    }


}
