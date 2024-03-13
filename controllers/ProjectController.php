<?php

namespace app\controllers;

//use \app\components\ZondaPayAPI;
use app\components\mgcms\tpay\TPayNotification;
use app\models\mgcms\db\User;
use app\models\SubscribeForm;
use phpseclib\Math\BigInteger;
use tpayLibs\src\_class_tpay\Notifications\BasicNotificationHandler;
use Yii;
use yii\base\BaseObject;
use yii\console\widgets\Table;
use yii\helpers\Json;
use yii\log\Logger;
use yii\web\Controller;
use app\models\mgcms\db\Project;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use \app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Payment;
use __;
use yii\web\Link;
use yii\web\Session;
use FiberPay\FiberPayClient;
use JWT;
use yii\validators\EmailValidator;

use app\components\mgcms\tpay\TPayTransaction;

use Web3\Web3;
use Web3\Contract;
use Web3\Methods\Eth\Accounts;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3p\EthereumTx\Transaction;
use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Checkout;
use CoinbaseCommerce\Resources\Charge;

class ProjectController extends \app\components\mgcms\MgCmsController
{

    public function actionIndex($categoryId = false, $status = Project::STATUS_ACTIVE, $type = false)
    {

        $query = Project::find()->where(['status' => $status]);
        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }
        if ($type) {
            $query->andWhere(['type' => $type]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
            'sort' => [
                'attributes' => [
                    'order' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categoryId' => $categoryId,
            'status' => $status,
            'type' => $type,
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionView($id)
    {
        $model = Project::find()->where(['id' => $id])->one();
        if (!$model) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }


        $subscribeForm = new SubscribeForm();
        if ($subscribeForm->load(Yii::$app->request->post()) && $subscribeForm->subscribe($model)) {
            MgHelpers::setFlashSuccess(MgHelpers::getSettingTranslated('email project subscription', 'Thank you for subscribing'));
            return $this->refresh();
        }

        return $this->render('view', ['model' => $model, 'subscribeForm' => $subscribeForm]);
    }

    public function actionBuyStripe($id)
    {

        if (!MgHelpers::getUserModel()) {
            MgHelpers::setFlashError(Yii::t('db', 'You must to be logged in'));
            return $this->redirect(['site/login']);
        }

        $user = User::findOne(MgHelpers::getUserModel()->id);

        $project = Project::find()
            ->where(['status' => Project::STATUS_ACTIVE, 'id' => $id])
            ->one();

        $payment = new Payment();
        $payment->project_id = $project->id;
        $payment->user_id = $user->id;
        $payment->status = Payment::STATUS_NEW;
        $payment->type = $project::class;
        $payment->scenario = 'invest';
        $payment->rate = $project->token_value;


        $loaded = $payment->load(Yii::$app->request->post());
        if ($loaded) {
            $amount = (double)$payment->amount;

            if ($amount > 1000 && !$user->is_verified) {
                MgHelpers::setFlash(MgHelpers::FLASH_TYPE_WARNING, Yii::t('db', 'You must to be verified before investing more than 1000$'));
                return $this->redirect('/account/verify-by-veriff');
            }
            $saved = $payment->save();
            if (!$saved) {
                MgHelpers::setFlashError(Yii::t('db', 'Problem with saving payment ' . MgHelpers::getErrorsString($payment->errors)));
                return $this->redirect(['site/login']);
            }
            try {


                $apiKey = MgHelpers::getSetting('stripe api key ' . $project->type, false, 'sk_test_51OCLLOIqVuogZFUBfxewE719UzsbKwV6sU0tC9miy8NYLpQZwvvYWGp4zzkjPLZprbzWipQZ8wMGRefu4yOmQsHc00lFI2zIYF');
                $stripeId = MgHelpers::getSetting('stripe account id ' . $project->type, false, 'acct_1OCLLOIqVuogZFUB');

                $stripe = new \Stripe\StripeClient($apiKey);
                $payment_intent = $stripe->paymentIntents->create([
                    'amount' => (int)($amount * 100),
                    'currency' => 'USD',
                    'automatic_payment_methods' => ['enabled' => true],
                ]);

                return $this->render('buyStripe', [
                    'clientSecret' => $payment_intent['client_secret'],
                    'stripeAccount' => $stripeId,
                    'project' => $project,
                    'returnUrl' => Url::to(['/project/buy-after', 'type' => 'success', 'hash' => MgHelpers::encrypt(serialize([
                        'payment_id' => $payment->id,
                        'project_id' => $project->id,
                        'amount' => $amount,
                        'user_id' => $this->getUserModel()->id,
                    ]))], true),
                ]);
            } catch (Exception $e) {
                MgHelpers::setFlashError(Yii::t('db', $e));
                return $this->back();
            }
        }

        //--------------------------------STEP 2 ---------------------------------
        return $this->render('buy', ['project' => $project, 'payment' => $payment]);

    }

    public function actionBuy($id)
    {

        if (!MgHelpers::getUserModel()) {
            MgHelpers::setFlashError(Yii::t('db', 'You must to be logged in'));
            return $this->redirect(['site/login']);
        }

        $user = User::findOne(MgHelpers::getUserModel()->id);

        $project = Project::find()
            ->where(['status' => Project::STATUS_ACTIVE, 'id' => $id])
            ->one();

        $payment = new Payment();
        $payment->project_id = $project->id;
        $payment->user_id = $user->id;
        $payment->status = Payment::STATUS_NEW;
        $payment->type = $project::class;
        $payment->scenario = 'invest';
        $payment->rate = $project->token_value;


        $loaded = $payment->load(Yii::$app->request->post());
        if ($loaded) {
            $amount = (double)$payment->amount;

            if ($amount > 1000 && !$user->is_verified) {
                MgHelpers::setFlash(MgHelpers::FLASH_TYPE_WARNING, Yii::t('db', 'You must to be verified before investing more than 1000$'));
                return $this->redirect('/account/verify-by-veriff');
            }
            $saved = $payment->save();
            if (!$saved) {
                MgHelpers::setFlashError(Yii::t('db', 'Problem with saving payment ' . MgHelpers::getErrorsString($payment->errors)));
                return $this->redirect(['site/login']);
            }
            try {

                ApiClient::init(MgHelpers::getSetting('coinbase api key', false, 'c4e3e3e3-3e3e-4e3e-3e3e-3e3e3e3e3e3e'));
                $chargeData = [
                    'name' => Yii::t('db', 'Buying tokens'),
                    'local_price' => [
                        'amount' => $amount,
                        'currency' => 'USD',
                    ],
                    'pricing_type' => 'fixed_price',
                    'metadata' => [
                        'paymentId' => $payment->id,
                        'userId' => $user->id,
                    ],
                ];

                try {
                    $charge = Charge::create($chargeData);
                    return $this->redirect($charge['hosted_url']);
                } catch (\Exception $e) {
                    // Obsłuż błędy
                    echo 'Error: ' . $e->getMessage();
                }
            } catch (Exception $e) {
                MgHelpers::setFlashError(Yii::t('db', $e));
                return $this->back();
            }
        }

        //--------------------------------STEP 2 ---------------------------------
        return $this->render('buy', ['project' => $project, 'payment' => $payment]);

    }

    public function actionNotifyCoinbase()
    {
        \Yii::info("actionNotifyCoinbase", 'own');


        $requestBody = file_get_contents('php://input');



        $data = json_decode($requestBody, true);

        \Yii::info($requestBody, 'own');

        $signature = $_SERVER['HTTP_X_CC_WEBHOOK_SIGNATURE'];

        \Yii::info($signature, 'own');

        $secretKey = MgHelpers::getSetting('coinbase api private key', false, 'c4e3e3e3-3e3e-4e3e-3e3e-3e3e3e3e3e3e');


        $calculatedSignature = hash_hmac('sha256', $requestBody, $secretKey);


        if ($calculatedSignature === $signature) {
            // Sygnatury są zgodne, dane są poprawne
            echo 'Webhook verification successful!';
            // Dodatkowo, tutaj możesz przetwarzać otrzymane dane z webhooka
        } else {
            // Sygnatury nie są zgodne, dane mogą być niepoprawne
            echo 'Webhook verification failed!';
        }
    }

    public function beforeAction($action)
    {
        if ($action->id == 'notify' || $action->id == 'notify-coinbase') {
            $this->enableCsrfValidation = false;
        }
        return true;
    }

    public function actionNotifyTPay($hash)
    {


        \Yii::info("notify", 'own');
        \Yii::info($hash, 'own');

//        $headers = JSON::decode('{"user-agent":["Apache-HttpClient/4.1.1 (java 1.5)"],"content-type":["application/json"],"accept":["application/json"],"api-key":["dNlZtEJrvaJDJ5EX"],"content-length":["1484"],"connection":["close"],"host":["piesto.vertesprojekty.pl"]}');
//        $body = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXlsb2FkIjp7Im9yZGVySXRlbSI6eyJkYXRhIjp7ImNvZGUiOiJhM3h2NnpnOSIsInN0YXR1cyI6InJlY2VpdmVkIiwidHlwZSI6ImNvbGxlY3RfaXRlbSIsImN1cnJlbmN5IjoiUExOIiwiYW1vdW50IjoiOC4wMCIsImZlZXMiOltdLCJ0b05hbWUiOiJhc2RzYSIsInBhcmVudENvZGUiOiJheWsyZ3FqczZoZDUiLCJkZXNjcmlwdGlvbiI6IlBpZXN0byIsIm1ldGFkYXRhIjpudWxsLCJjcmVhdGVkQXQiOiIyMDIxLTA2LTMwIDIxOjUyOjA3IiwidXBkYXRlZEF0IjoiMjAyMS0wNi0zMCAyMTo1MjoyMCIsInJlZGlyZWN0IjoiaHR0cHM6XC9cL3Rlc3QuZmliZXJwYXkucGxcL29yZGVyXC9hM3h2NnpnOSJ9LCJpbnZvaWNlIjp7ImFtb3VudCI6IjguMDAiLCJjdXJyZW5jeSI6IlBMTiIsImliYW4iOiJQTDE5MTk0MDEwNzYzMjAyODAxMDAwMDJURVNUIiwiYmJhbiI6IjE5MTk0MDEwNzYzMjAyODAxMDAwMDJURVNUIiwiZGVzY3JpcHRpb24iOiJhM3h2NnpnOSJ9LCJsaW5rcyI6eyJyZWwiOiJzZWxmIiwiaHJlZiI6Imh0dHBzOlwvXC9hcGl0ZXN0LmZpYmVycGF5LnBsXC8xLjBcL29yZGVyc1wvY29sbGVjdFwvaXRlbVwvYTN4djZ6ZzkifX0sInRyYW5zYWN0aW9uIjp7ImRhdGEiOnsiY29udHJhY3Rvck5hbWUiOiJGaWJlclBheSAtIHphcFx1MDE0MmFjb25vIHByemV6IHRlc3RlciIsImNvbnRyYWN0b3JJYmFuIjoiRmliZXJQYXkiLCJhbW91bnQiOiI4LjAwIiwiY3VycmVuY3kiOiJQTE4iLCJkZXNjcmlwdGlvbiI6ImEzeHY2emc5IiwiYmFua1JlZmVyZW5jZUNvZGUiOiJURVNUX2FrNGJobmVjIiwib3BlcmF0aW9uQ29kZSI6bnVsbCwiYWNjb3VudEliYW4iOiIiLCJib29rZWRBdCI6IjIwMjEtMDYtMzAgMjE6NTI6MjAiLCJjcmVhdGVkQXQiOiIyMDIxLTA2LTMwIDIxOjUyOjIwIiwidXBkYXRlZEF0IjoiMjAyMS0wNi0zMCAyMTo1MjoyMCJ9LCJ0eXBlIjoiYmFua1RyYW5zYWN0aW9uIn0sInR5cGUiOiJjb2xsZWN0X29yZGVyX2l0ZW1fcmVjZWl2ZWQiLCJjdXN0b21QYXJhbXMiOm51bGx9LCJpc3MiOiJGaWJlcnBheSIsImlhdCI6MTYyNTA4Mjc4NH0.5UqfPL-CF-58Si1wAEQ1fiZjwknxPxLu08cWgfJMm80';
//        \Yii::info(JSON::encode($this->request->headers), 'own');
//        \Yii::info(JSON::encode($this->request->rawBody), 'own');

        $hashDecrypt = MgHelpers::decrypt($hash);
        if (!$hashDecrypt) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }

        $hashUnserialized = unserialize($hashDecrypt);
        \Yii::info("hash unserialized", 'own');
        \Yii::info($hashUnserialized, 'own');

        $paymentId = $hashUnserialized['payment_id'];
        $projectId = $hashUnserialized['project_id'];
        $userId = $hashUnserialized['user_id'];
        if (!$paymentId || !$projectId || !$userId) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }

        $payment = Payment::find()->where(['id' => $paymentId])->one();
        if (!$payment) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }


        $config = MgHelpers::getConfigParam('tpay');
        $notificationHandler = new TPayNotification($config);
        $res = $notificationHandler->getTpayNotification();
        \Yii::info("payment veryfication", 'own');
        \Yii::info($res, 'own');

        if ($res['tr_status'] == 'TRUE') {
            $payment->status = Payment::STATUS_PAYMENT_CONFIRMED;
        } else {
            $payment->status = Payment::STATUS_SUSPENDED;
        }


        $saved = $payment->save();

        $project = $payment->project;
        $project->money += $payment->amount;
        $project->save();
        \Yii::info($saved, 'own');
        \Yii::info($payment->errors, 'own');


        return 'OK';
    }

    public function actionNotifyPrzelewy24($hash)
    {
        \Yii::info("notifyp24", 'own');
        \Yii::info($hash, 'own');

        \Yii::info("post", 'own');
        \Yii::info(Yii::$app->request->post(), 'own');


        $hashDecoded = JSON::decode(MgHelpers::decrypt($hash));
        \Yii::info($hashDecoded, 'own');
        $paymentId = $hashDecoded['paymentId'];
        $userId = $hashDecoded['userId'];
        $payment = Payment::find()->where(['id' => $paymentId, 'user_id' => $userId])->one();
        if (!$payment) {
            $this->throw404();
        }

        $przelewy24ConfigParams = MgHelpers::getConfigParam('przelewy24');
        $przelewy24Config = [
            'live' => $przelewy24ConfigParams['live'],
            'merchant_id' => $payment->project->przelewy24_merchant_id,
            'crc' => $payment->project->przelewy24_crc
        ];
        $przelewy24 = new Przelewy24($przelewy24Config);

        $webhook = $przelewy24->handleWebhook();

        \Yii::info("webhook", 'own');
        \Yii::info($webhook, 'own');


        try {

            $verifyData = [
                'session_id' => $payment->id,
                'order_id' => $webhook->orderId(),
                'amount' => (int)($payment->amount * 100),
            ];
            \Yii::info('verifyData:', 'own');
            \Yii::info($verifyData, 'own');
            $verificationRes = $przelewy24->verify($verifyData);

            $payment->status = Payment::STATUS_PAYMENT_CONFIRMED;
            $project = $payment->project;
            $project->money += $payment->amount;
            $saved = $project->save();

        } catch (Przelewy24Exception $e) {
            \Yii::info('error:', 'own');
            \Yii::info($e, 'own');
        }


        return 'OK';
    }

    public function actionBuyThankYou($hash)
    {
        $hashDecrypt = MgHelpers::decrypt($hash);
        if (!$hashDecrypt) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }

        $hashUnserialized = unserialize($hashDecrypt);

        if (!$hashUnserialized['payment_id'] || !$hashUnserialized['user_id']) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }

        $userModel = MgHelpers::getUserModel();
        if ($hashUnserialized['user_id'] != $userModel->id) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }

        $payment = Payment::find()->where(['id' => $hashUnserialized['payment_id']])->one();
        if (!$payment) {
            throw new \yii\web\HttpException(404, Yii::t('app', 'Not found'));
        }

        $project = $payment->project;
//        $payment->status = Payment::STATUS_AFTER_PAYMENT;
//        $payment->save();


        Yii::$app->mailer->compose('afterBuy', ['project' => $project])
            ->setTo($userModel->email ?: $userModel->username)
            ->setFrom([MgHelpers::getSetting('email from') => MgHelpers::getSetting('email from name')])
            ->setSubject(Yii::t('db', 'Investition'))
            ->send();

        return $this->render('buyThanks', [
        ]);
    }

    /**
     * @param $amount
     * @param $project Project
     * @return void
     */
    private function sendSmartContract($amount, $project, $tokenName, $incrementNonce = false)
    {
        $fromAddress = MgHelpers::getSetting('eth.walletId', false, '0x21F298D212ef980fF5f9721Eb5A386644e543aDF');
        //$senderAddress = preg_replace('/^0x/','',$senderAddress);
        $privateKey = MgHelpers::getSetting('eth.walletPrivateKey', false, '');
        $fromPrivateKey = preg_replace('/^0x/', '', $privateKey);
        $networkUrl = MgHelpers::getSetting('eth.blockChainEndpoint', false, 'https://rpc.ankr.com/bsc_testnet_chapel');
        $networkId = MgHelpers::getSetting('eth.chainId', false, '97');;
        $abi = MgHelpers::getSetting('eth.jsonAbi-' . $tokenName, false, '[{"inputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"string","name":"symbol","type":"string"},{"internalType":"uint256","name":"initialSupply","type":"uint256"},{"internalType":"address","name":"holder","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"stateMutability":"pure","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"}]');

        $contractAddress = MgHelpers::getSetting('eth.tokenAddress-' . $tokenName, false, '0xEe108353Ef9493e0525eB8da0Dcd00caa098c62d');

        $user = MgHelpers::getUserModel();
        $toAddress = $user->getModelAttribute('ethAddress');

        $amount = ($amount / $project->token_value);

        $amountHex = '0x' . dechex($amount * 10 ** 8);

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

        if ($incrementNonce) {
            $transactionCount = $transactionCount->add(new BigInteger('1'));
        }

        $contract->eth->gasPrice(function ($err, $price) use (&$gasPrice) {
            if ($err) {
                echo $err->getMessage() . "\n";
                return;
            }
            $gasPrice = $price;
        });


        $transactionData = '0x' . $contract->at($contractAddress)->getData('transfer', $toAddress, $amountHex);

        $transactionParams = [
            'nonce' => '0x' . dechex($transactionCount->toString()),
            'from' => $fromAddress,
            'to' => $contractAddress,
            'gasPrice' => '0x' . dechex($gasPrice->toString()),
            'value' => '0x0',
            'data' => $transactionData,
            'chainId' => $networkId
        ];

        $contract->at($contractAddress)->estimateGas('transfer', $toAddress, $amountHex, ['from' => $fromAddress], function ($err, $estimate) use (&$gas) {
            if ($err) {
                Log::info("estimate gas error: " . $err->getMessage());
            }
            $gas = $estimate;
        });

        $transactionParams['gas'] = '0x' . dechex($gas->toString());

        $transaction = new Transaction($transactionParams);
        $signedTransaction = $transaction->sign($fromPrivateKey);

        $transactionHash = false;
        $contract->eth->sendRawTransaction('0x' . $signedTransaction, function ($err, $tx) use (&$transactionHash) {
            if ($err) {
                echo $err->getMessage() . "\n";
                return;
            }
            $transactionHash = $tx;
        });

        return $transactionHash;
    }


    private function getCryptocurrency($currency)
    {
        $url = "https://api.alternative.me/v2/ticker/" . $currency . "/";
        $response = Json::decode(file_get_contents($url));
        return $response;
    }

    public function actionCalculator()
    {

        $btc = $this->getCryptocurrency('bitcoin');
        $eth = $this->getCryptocurrency('ethereum');

        $output = [];
        $btc_value = $btc['data']['1']['quotes']['USD']['price'];
        $eth_value = $eth['data']['1027']['quotes']['USD']['price'];

        if (isset($_POST['capital'])) {
            $capital = $_POST['capital'];
            $output['capital'] = $capital;
            $output['capital_btc'] = $capital / $btc_value;
            $output['capital_eth'] = $capital / $eth_value;

        } elseif (isset($_POST['capital_eth'])) {


            $capital_eth = $_POST['capital_eth'];
            $capital = $capital_eth * $eth_value;

            $output['capital'] = $capital;
            $output['capital_btc'] = $capital / $btc_value;
            $output['capital_eth'] = $capital_eth;

        } elseif (isset($_POST['capital_btc'])) {

            $capital_btc = $_POST['capital_btc'];
            $capital = $capital_btc * $btc_value;

            $output['capital'] = $capital;
            $output['capital_btc'] = $capital_btc;
            $output['capital_eth'] = $capital / $eth_value;

        }

        $output['income'] = $capital + ($capital * (intval(($_POST['percentage'])) / 100 * $_POST['investition_time']));

        return json_encode($output);
    }


    public function actionBuyTestTpay()
    {
        $config = [
            'amount' => 999.99,
            'description' => 'Transaction description',
            //'crc' => '100020003000',
            'result_url' => 'http://example.pl/examples/TransactionApiExample.php?transaction_confirmation',
            'result_email' => 'shop@example.com',
            'return_url' => 'http://example.pl/examples/TransactionApiExample.php',
            'email' => 'customer@example.com',
            'name' => 'John Doe',
            'group' => isset($_POST['group']) ? (int)$_POST['group'] : 150,
            'accept_tos' => 1,
        ];


        try {
            $transactionSdk = new TPayTransaction(MgHelpers::getConfigParam('tpay'));
            $url = $transactionSdk->createRedirUrlForTransaction($config);
            return $this->redirect($url);
        } catch (Exception $e) {

        }


        return $this->render('buyTest');
    }

    public function actionGenerateDocument($name)
    {

        $engine = new \app\components\mgcms\docRepl\docRepl();
        $engine->loadTemplate(Yii::getAlias('@app/web/files/' . $name . '.docx'));

        $model = $this->getUserModel();
        $data = [

        ];

        foreach ($model->getAttributes() as $attr => $value) {
            $data['user_' . $attr] = $value;
        }

        $engine->replace($data);

        $tempName = md5(time()) . '.docx';

        $engine->save($tempName);

        header('Content-Disposition: attachment; filename="' . $name . '.docx"');

        echo file_get_contents($tempName);

        unlink($tempName);
    }

    function actionBuyAfter($type, $hash)
    {
        $data = unserialize(MgHelpers::decrypt($hash));
        if (!isset($data['user_id']) || !isset($data['project_id']) || !isset($data['amount']) || !isset($data['payment_id'])) {
            return $this->throw404();
        }

        $transactionHash = false;
        if ($type == 'success') {
            $payment = Payment::find()->where(['id' => $data['payment_id']])->one();
            if (!$payment || $payment->status == Payment::STATUS_PAYMENT_CONFIRMED) {
                return $this->throw404();
            }

            $payment->status = Payment::STATUS_PAYMENT_CONFIRMED;
            $payment->save();
            $project = $payment->project;
            $project->money += $payment->amount;
            $project->save();

            switch ($project->type) {
                case Project::TYPE_ECM:
                    $transactionHash = $this->sendSmartContract($payment->amount, $project, 'ECM');
                    $transactionHash = $transactionHash . ',' . $this->sendSmartContract($payment->amount, $project, 'SDT1', true);
                    break;
                default:
                    $transactionHash = $this->sendSmartContract($payment->amount, $project, $project->token_name);
                    break;

            }
            $payment->hash = $transactionHash;
            $payment->save();

        }


        return $this->render('buyAfter', ['type' => $type, 'payment' => $payment, 'transactionHash' => $transactionHash]);
    }


}
