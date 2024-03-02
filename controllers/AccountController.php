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
use Web3\Contract;
use Web3\Methods\Eth\Accounts;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3p\EthereumTx\Transaction;


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

    public function beforeAction($action)
    {
        if ($action->id == 'verify-by-veriff-webhook') {
            $this->enableCsrfValidation = false;
        }
        return true;
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($tab = 'main')
    {

        $model = $this->getUserModel();
        if(!$model) {
            return $this->redirect(['site/login']);
        }
        // $model->scenario = 'account';

        if (Yii::$app->request->post('User')) {
            if (null !== Yii::$app->request->post('passwordChanging')) {
                $model->scenario = 'passwordChanging';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $upladedFile = UploadedFile::getInstance($model, 'fileUpload');
                if ($upladedFile) {
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
        if (!$user) {
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

    public function actionVerifyByVeriff()
    {
        if(!MgHelpers::getUserModel()) {
            return $this->redirect(['site/login']);
        }
        return $this->render('verifyByVeriff', []);
    }

    public function actionVerifyByVeriffWebhook()
    {

        $this->enableCsrfValidation = false;
        \Yii::info("actionVerifyByVeriffWebhook", 'own');
        \Yii::info(Yii::$app->request->getRawBody(), 'own');

        $body = Yii::$app->request->getRawBody();
        //$body = '{"status":"success","verification":{"acceptanceTime":"2024-01-10T21:55:02.277043Z","decisionTime":"2024-01-10T22:00:26.226341Z","code":9001,"id":"0de73ae1-b6f7-4e85-902a-ce4353410a61","vendorData":"1","status":"approved","reason":null,"reasonCode":null,"person":{"firstName":"Marcin","lastName":"Galus","citizenship":null,"idNumber":null,"gender":null,"dateOfBirth":null,"yearOfBirth":null,"placeOfBirth":null,"nationality":null,"pepSanctionMatch":null},"document":{"number":null,"type":"ID_CARD","country":"PL","validFrom":null,"validUntil":null},"comments":[],"additionalVerifiedData":{}},"technicalData":{"ip":"89.231.203.203"}}';
        $data = Json::decode($body);


        $verificationStatus = \_::get($data, 'verification.status');
        if(!$verificationStatus) {
            $verificationStatus = \_::get($data, 'data.verification.decision');
        }
        $userId = \_::get($data, 'verification.vendorData');
        if(!$userId) {
            $userId = \_::get($data, 'vendorData');
        }

        if ($verificationStatus === 'approved' && $userId) {
            $user = User::find()->where(['id' => $userId])->one();
            if ($user) {
                $user->is_verified = 1;
                $user->save();
                if($user->errors){
                    \Yii::info(MgHelpers::getErrorsString($user->errors), 'own');
                }
            }

        }

        return 'ok';
    }


    public function actionSmartcontractTest()
    {
        $fromAddress = MgHelpers::getSetting('eth.walletId', false, '0x21F298D212ef980fF5f9721Eb5A386644e543aDF');
        //$senderAddress = preg_replace('/^0x/','',$senderAddress);
        $privateKey = MgHelpers::getSetting('eth.walletPrivateKey', false, '');
        $fromPrivateKey = preg_replace('/^0x/', '', $privateKey);
        $networkUrl = MgHelpers::getSetting('eth.blockChainEndpoint', false, 'https://rpc.ankr.com/bsc_testnet_chapel');
        $networkId = MgHelpers::getSetting('eth.chainId', false, '97');
        $tokenName = 'ECM';
        $abi = MgHelpers::getSetting('eth.jsonAbi-' . $tokenName, false, '[{"inputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"string","name":"symbol","type":"string"},{"internalType":"uint256","name":"initialSupply","type":"uint256"},{"internalType":"address","name":"holder","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"stateMutability":"pure","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"}]');
        $tokenAbi = json_decode($abi, true);

        $contractAddress = MgHelpers::getSetting('eth.tokenAddress-' . $tokenName, false, '0xEe108353Ef9493e0525eB8da0Dcd00caa098c62d');

        $user = MgHelpers::getUserModel();
        $toAddress = $user->getModelAttribute('ethAddress');


        $amount = 1;
        $amountHex = '0x'.dechex($amount*10**8);


        $gasPrice = (int)MgHelpers::getSetting('eth.gasPrice', false, 5 * 10 ** 9);
        $gasLimit = (int)MgHelpers::getSetting('eth.gasLimit', false, 100000);

        $provider = new HttpProvider(new HttpRequestManager($networkUrl, 30));
        $contract = new Contract($provider, $abi);

        $contract->eth->getTransactionCount($fromAddress, function ($err, $count) use (&$transactionCount) {
            if ($err) {
                echo $err->getMessage() . "\n";
                return;
            }
            $transactionCount = $count;
        });

        $contract->eth->gasPrice(function ($err, $price) use (&$gasPrice) {
            if ($err) {
                echo $err->getMessage() . "\n";
                return;
            }
            $gasPrice = $price;
        });

        // 0x3B9ACA00 => 10 00000000 (10 tokenów, 8 miejsc po przecinku, napisz jakiś konwerter)
        $transactionData = '0x' . $contract->at($contractAddress)->getData('transfer', $toAddress, '0x3B9ACA00');

        $transactionParams = [
            'nonce' => '0x' . dechex($transactionCount->toString()),
            'from' => $fromAddress,
            'to' => $contractAddress,
            'gasPrice' => '0x' . dechex($gasPrice->toString()),
            'value' => '0x0',
            'data' => $transactionData,
            'chainId' => $networkId
        ];

        $contract->at($contractAddress)->estimateGas('transfer', $toAddress, '0x3B9ACA00', ['from' => $fromAddress], function ($err, $estimate) use (&$gas) {
            if ($err) {
                Log::info("estimate gas error: " . $err->getMessage());
            }
            $gas = $estimate;
        });

        $transactionParams['gas'] = '0x' . dechex($gas->toString());

        $transaction = new Transaction($transactionParams);
        $signedTransaction = $transaction->sign($fromPrivateKey);

        $contract->eth->sendRawTransaction('0x' . $signedTransaction, function ($err, $tx) {
            if ($err) {
                echo $err->getMessage() . "\n";
                return;
            }
            echo $tx . "\n";
        });


//        return $this->render('smartcontractTest', [
//            'senderAddress' => $senderAddress,
//            'receiverAddress' => $receiverAddress,
//            'tokenAbi' => $tokenAbi,
//            'privateKey' => $privateKey,
//            'tokenAddress' => $tokenAddress,
//            'ethProvider' => $blockChainEndpoint,
//        ]);
    }


}
