<?php

namespace app\controllers;

//use \app\components\ZondaPayAPI;
use app\components\mgcms\tpay\TPayNotification;
use app\models\mgcms\db\User;
use app\models\SubscribeForm;
use phpseclib\Math\BigInteger;
use Yii;
use yii\helpers\Json;
use app\models\mgcms\db\Project;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use \app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Payment;
use __;

use app\components\mgcms\tpay\TPayTransaction;

use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3p\EthereumTx\Transaction;
use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Charge;
use HotpayMoney\ApiClient as HotpayApiClient;
use function _\get;

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
        $payment->engine = Yii::$app->request->post('paymentEngine');


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

            switch (Yii::$app->request->post('paymentEngine')) {
                case 'coinbase':
                    return $this->_payCoinbase($amount, $payment, $user);
                    break;
                case 'hotpay':
                    return $this->_payHotpay($amount, $payment, $user);
                    break;
                case 'stripe':
                    return $this->_payStripe($amount, $payment, $user);
                    break;
            }

        }

        //--------------------------------STEP 2 ---------------------------------
        return $this->render('buy', ['project' => $project, 'payment' => $payment]);

    }

    /**
     * @param $amount
     * @param $payment Payment
     * @param $user User
     * @return void|\yii\web\Response
     */
    private function _payCoinbase($amount, $payment, $user)
    {
        try {
            ApiClient::init(MgHelpers::getSetting('coinbase api key - ' . $payment->project->token_name, false, 'c4e3e3e3-3e3e-4e3e-3e3e-3e3e3e3e3e3e'));
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

    private function _payHotpay($amount, $payment, $user)
    {
        if (!$payment->project->hotpay_sekret) {
            MgHelpers::getErrorsString(Yii::t('db', 'Hotpay secret is not set'));
            return $this->back();
        }
        return $this->render('buyHotpay', ['payment' => $payment]);
    }

    private function _payStripe($amount, $payment, $user)
    {
        try {

            $project = $payment->project;
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

    public function actionNotifyHotpay()
    {
        \Yii::info("actionNotifyHotpay", 'own');
        \Yii::info(serialize($_POST), 'own');

        /*
$_POST["KWOTA"] - wartość płatności
$_POST["ID_PLATNOSCI"] - unikalne id płatności
$_POST["ID_ZAMOWIENIA"] - id zamówienia podane podczas inicjacji
$_POST["STATUS"] - FAILURE / SUCCESS / PENDING
$_POST["SEKRET"] - sekret danej usługi
$_POST["SECURE"] - oznaczenie bezpiecznej transakcji
$_POST["HASH"] - hash funkcji skrótu sha256, składającej się z hash("sha256","HASLOZUSTAWIEN;".$_POST["KWOTA"].";".$_POST["ID_PLATNOSCI"].";".$_POST["ID_ZAMOWIENIA"].";".$_POST["STATUS"].";".$_POST["SECURE"].";".$_POST["SEKRET"])
*/
        $hasloZUstawien = MgHelpers::getSetting('hotpay haslo', false, 'xxx');
        if (!empty($_POST)) {
            if (!empty($_POST["KWOTA"]) &&
                !empty($_POST["ID_PLATNOSCI"]) &&
                !empty($_POST["ID_ZAMOWIENIA"]) &&
                !empty($_POST["STATUS"]) &&
                !empty($_POST["SEKRET"]) &&
                !empty($_POST["SECURE"]) &&
                !empty($_POST["HASH"])
            ) {
                if (hash("sha256", $hasloZUstawien . ";" . $_POST["KWOTA"] . ";" . $_POST["ID_PLATNOSCI"] . ";" . $_POST["ID_ZAMOWIENIA"] . ";" . $_POST["STATUS"] . ";" . $_POST["SECURE"] . ";" . $_POST["SEKRET"]) == $_POST["HASH"]) {
                    //komunikacja poprawna
                    $payment = Payment::find()->where(['id' => $_POST["ID_ZAMOWIENIA"]])->one();
                    if (!$payment) {
                        \Yii::info("no such payment ", 'own');
                        return;
                    }
                    if ($_POST["STATUS"] == "SUCCESS") {
                        //płatność zaakceptowana
                        \Yii::info("success", 'own');
                        try {
                            $this->_afterSuccessPayment($payment);
                        } catch (\Exception $e) {
                            \Yii::info("error", 'own');
                            \Yii::info($e, 'own');
                        }

                        echo "Płatność została poprawnie opłacona";
                    } else if ($_POST["STATUS"] == "FAILURE") {
                        $payment->status = Payment::STATUS_SUSPENDED;
                        $payment->save();
                        //odrzucone
                        \Yii::info("failed", 'own');
                        echo "Płatność zakończyła się błędem";
                    } else if ($_POST["STATUS"] == "PENDING") {
                        //odrzucone
                        echo "Płatność oczekuje na realizacje";
                    }
                }
            } else {
                echo "BRAK WYMAGANYCH DANYCH";
            }
        }


    }

    public function actionNotifyCoinbase()
    {
        \Yii::info("actionNotifyCoinbase", 'own');


        $requestBody = file_get_contents('php://input');

        //$requestBody = '{"attempt_number":4,"event":{"api_version":"2018-03-22","created_at":"2024-05-06T11:36:29Z","data":{"id":"90307290-b11b-4a8f-824c-31892988e92e","code":"YYDY6XEE","name":"Buying tokens","pricing":{"local":{"amount":"4.75","currency":"USD"},"settlement":{"amount":"4.75","currency":"USDC"}},"metadata":{"userId":"159.0","paymentId":"333.0"},"payments":[{"value":{"local":{"amount":"4.75","currency":"USD"},"crypto":{"amount":"4.75","currency":"USDC"}},"status":"confirmed","network":"base","payment_id":"0xb9c747b5f67402a2bb8a50d2efdb7d94db7a4a510a1fc93aa51aab862bf3785a","detected_at":"2024-05-06T11:22:27Z","transaction_id":"0xb9c747b5f67402a2bb8a50d2efdb7d94db7a4a510a1fc93aa51aab862bf3785a","payer_addresses":["0x8545eb636855e894a0a4e8f6fc687ae9b0209a78"]}],"timeline":[{"time":"2024-05-06T11:21:38Z","status":"NEW"},{"time":"2024-05-06T11:22:08Z","status":"SIGNED"},{"time":"2024-05-06T11:22:39Z","status":"PENDING"},{"time":"2024-05-06T11:36:29Z","status":"COMPLETED"}],"pwcb_only":false,"redirects":{"cancel_url":"","success_url":"","will_redirect_after_success":false},"web3_data":{"failure_events":[],"success_events":[{"sender":"0x8545eb636855e894a0a4e8f6fc687ae9b0209a78","tx_hsh":"0xb9c747b5f67402a2bb8a50d2efdb7d94db7a4a510a1fc93aa51aab862bf3785a","chain_id":8453,"finalized":false,"recipient":"0x77471cba762baf138e0b68acb6ec522264dc6e7e","timestamp":"2024-05-06T11:22:27Z","network_fee_paid":"14633393928256","input_token_amount":"1506802643728523","input_token_address":"0x0000000000000000000000000000000000000000","network_fee_paid_local":"0.046132506028518338"},{"sender":"0x8545eb636855e894a0a4e8f6fc687ae9b0209a78","tx_hsh":"0xb9c747b5f67402a2bb8a50d2efdb7d94db7a4a510a1fc93aa51aab862bf3785a","chain_id":8453,"finalized":true,"recipient":"0x77471cba762baf138e0b68acb6ec522264dc6e7e","timestamp":"2024-05-06T11:22:27Z","network_fee_paid":"14633393928256","input_token_amount":"1506802643728523","input_token_address":"0x0000000000000000000000000000000000000000","network_fee_paid_local":"0.046132506028518338"}],"transfer_intent":{"metadata":{"sender":"0x8545eB636855e894a0a4E8F6fc687ae9b0209a78","chain_id":8453,"contract_address":"0xeF0D482Daa16fa86776Bc582Aff3dFce8d9b8396"},"call_data":{"id":"0x7f2bb24643ea413c8d619873fb5dcd33","prefix":"0x4b3220496e666f726d6174696f6e616c204d6573736167653a20333220","deadline":"2024-05-08T11:21:38Z","operator":"0x8fccc78dae0a8f93b0fe6799de888d4c57e273db","recipient":"0x77471CBa762BaF138E0b68ACB6Ec522264Dc6E7E","signature":"0x696c0f50dd3709606c47efc8067da3f9f5d628a129ab33602b766b7e6eb4294f750538fb4b69b021654214f5380b2e24566211cbb4594d9e2936ee47e5a8b46a1b","fee_amount":"47500","recipient_amount":"4702500","recipient_currency":"0x833589fCD6eDb6E08f4c7C32D4f71b54bdA02913","refund_destination":"0x8545eB636855e894a0a4E8F6fc687ae9b0209a78"}},"contract_addresses":{"1":"0x3263bc4976C8c180bd5EB90a57ED1A2f1CFcAC67","137":"0x551c6791c2f01c3Cd48CD35291Ac4339F206430d","8453":"0xeF0D482Daa16fa86776Bc582Aff3dFce8d9b8396"},"contract_caller_request_id":"","settlement_currency_addresses":{"1":"0xA0b86991c6218b36c1d19D4a2e9Eb0cE3606eB48","137":"0x3c499c542cEF5E3811e1192ce70d8cC03d5c3359","8453":"0x833589fCD6eDb6E08f4c7C32D4f71b54bdA02913"},"subsidized_payments_chain_to_tokens":{"1":{"token_addresses":[""]},"137":{"token_addresses":["0x3c499c542cEF5E3811e1192ce70d8cC03d5c3359"]},"8453":{"token_addresses":["0x833589fCD6eDb6E08f4c7C32D4f71b54bdA02913"]}}},"created_at":"2024-05-06T11:21:38Z","expires_at":"2024-05-08T11:21:38Z","hosted_url":"https://commerce.coinbase.com/pay/90307290-b11b-4a8f-824c-31892988e92e","brand_color":"#5A97C4","charge_kind":"WEB3","confirmed_at":"2024-05-06T11:36:29Z","pricing_type":"fixed_price","support_email":"office@ecmarket.eu","brand_logo_url":"https://res.cloudinary.com/commerce/image/upload/v1713195076/zcr6nnfuqhpv7yuo2irk.png","collected_email":false,"organization_name":"ENERGY COIN MARKET SPÓŁKA Z OGRANICZONĄ ODPOWIEDZIALNOŚCIĄ","web3_retail_payment_metadata":{"fees":[],"quote_id":"","source_amount":{"amount":null,"currency":null},"max_payment_value_usd":10000,"exchange_rate_with_spread":{"amount":null,"currency":null},"exchange_rate_without_spread":{"amount":null,"currency":null}},"web3_retail_payments_enabled":false},"id":"329fbbae-072d-4c81-902b-90706aea07e0","resource":"event","type":"charge:confirmed"},"id":"ad78dde0-55bc-48d1-bd98-42bc86d956c3","scheduled_for":"2024-05-06T11:38:20Z"}';

        $data = json_decode($requestBody, true);

        \Yii::info($requestBody, 'own');

        $signature = $_SERVER['HTTP_X_CC_WEBHOOK_SIGNATURE'];

        \Yii::info($signature, 'own');

        $secretKey = MgHelpers::getSetting('coinbase api private key', false, 'c4e3e3e3-3e3e-4e3e-3e3e-3e3e3e3e3e3e');


        $calculatedSignature = hash_hmac('sha256', $requestBody, $secretKey);

        \Yii::info("actionNotifyCoinbase signature " . $calculatedSignature . '-' . $signature, 'own');

        if ($calculatedSignature === $signature) {
            \Yii::info("actionNotifyCoinbase successful", 'own');
            echo 'Webhook verification successful!';
            $paymentId = (int)get($data, 'event.data.metadata.paymentId');
            $userId = (int)get($data, 'event.data.metadata.userId');
            $status = get($data, 'event.data.payments.0.status');
            \Yii::info("actionNotifyCoinbase status " . $status, 'own');

            if ($status === 'confirmed') {
                $payment = Payment::find()->where([
                    'id' => $paymentId,
                    'user_id' => $userId])->one();

                if (!$payment) {
                    \Yii::info("no such payment $paymentId for user $userId", 'own');
                    return 404;
                }
                return $this->_afterSuccessPayment($payment);
            } else {
                return 200;
            }

        } else {
            \Yii::info("actionNotifyCoinbase failed", 'own');
            echo 'Webhook verification failed!';
        }
    }

    public function beforeAction($action)
    {
        if ($action->id == 'notify' || $action->id == 'notify-coinbase' || $action->id == 'notify-hotpay') {
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
    private function sendSmartContract($payment, $project, $tokenName, $forECM = false)
    {
        try {
            \Yii::info("sendSmartContract", 'own');
            $fromAddress = $forECM ? MgHelpers::getSetting('eth.walletId.ECM', false, '0x21F298D212ef980fF5f9721Eb5A386644e543aDF') : MgHelpers::getSetting('eth.walletId.' . $tokenName, false, '0x21F298D212ef980fF5f9721Eb5A386644e543aDF');
            //$senderAddress = preg_replace('/^0x/','',$senderAddress);
            $privateKey = $forECM ? MgHelpers::getSetting('eth.walletPrivateKey.ECM', false, '') : MgHelpers::getSetting('eth.walletPrivateKey.' . $tokenName, false, '');
            $fromPrivateKey = preg_replace('/^0x/', '', $privateKey);
            $networkUrl = MgHelpers::getSetting('eth.blockChainEndpoint', false, 'https://rpc.ankr.com/bsc_testnet_chapel');
            $networkId = MgHelpers::getSetting('eth.chainId', false, '97');;
            $abi = MgHelpers::getSetting('eth.jsonAbi-' . $tokenName, false, '[{"inputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"string","name":"symbol","type":"string"},{"internalType":"uint256","name":"initialSupply","type":"uint256"},{"internalType":"address","name":"holder","type":"address"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"stateMutability":"pure","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"from","type":"address"},{"internalType":"address","name":"to","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"}]');
            \Yii::info("sendSmartContract 2", 'own');
            $contractAddress = MgHelpers::getSetting('eth.tokenAddress-' . $tokenName, false, '0xEe108353Ef9493e0525eB8da0Dcd00caa098c62d');
            \Yii::info("sendSmartContract contractAddress $contractAddress", 'own');

            $user = $payment->user;
            $toAddress = $user->getModelAttribute('ethAddress');
            \Yii::info("sendSmartContract 2 toAddress $toAddress", 'own');

            $amount = ($payment->amount / $project->token_value);

            \Yii::info("sendSmartContract 2 amount $amount", 'own');

            $amountHex = '0x' . dechex($amount * 10 ** 8);

            $gasPrice = (int)MgHelpers::getSetting('eth.gasPrice', false, 5 * 10 ** 9);
            $gasLimit = (int)MgHelpers::getSetting('eth.gasLimit', false, 100000);

            \Yii::info("sendSmartContract 2 networkUrl $networkUrl", 'own');
            $provider = new HttpProvider($networkUrl, 30);
            \Yii::info("sendSmartContract 2 abi $abi", 'own');
            $contract = new Contract($provider, $abi);


            Yii::info("sendSmartContract 3", 'own');
            $contract->eth->getTransactionCount($fromAddress, function ($err, $count) use (&$transactionCount) {
                if ($err) {
                    Yii::info("sendSmartContract 3 " . $err->getMessage(), 'own');
                    echo $err->getMessage() . "\n";
                    return;
                }
                $transactionCount = $count;
            });

            Yii::info("sendSmartContract 4", 'own');
            if ($forECM) {
                $transactionCount = $transactionCount->add(new BigInteger('1'));
            }

            $contract->eth->gasPrice(function ($err, $price) use (&$gasPrice) {
                if ($err) {
                    Yii::info("sendSmartContract 4 " . $err->getMessage(), 'own');
                    echo $err->getMessage() . "\n";
                    return;
                }
                $gasPrice = $price;
            });


            Yii::info("sendSmartContract 5", 'own');

            $transactionData = '0x' . $contract->at($contractAddress)->getData('transfer', $toAddress, $amountHex);

            Yii::info("sendSmartContract 6", 'own');
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
                    Yii::info("estimate gas error " . $err->getMessage(), 'own');
                    Log::info("estimate gas error: " . $err->getMessage());
                }
                $gas = $estimate;
            });

            Yii::info("sendSmartContract 7", 'own');
            $transactionParams['gas'] = '0x' . dechex($gas->toString());

            $transaction = new Transaction($transactionParams);
            $signedTransaction = $transaction->sign($fromPrivateKey);

            Yii::info("sendSmartContract 8", 'own');
            $transactionHash = false;
            $contract->eth->sendRawTransaction('0x' . $signedTransaction, function ($err, $tx) use (&$transactionHash) {
                if ($err) {
                    Yii::info("sendRawTransaction " . $err->getMessage(), 'own');
                    echo $err->getMessage() . "\n";
                    return;
                }
                $transactionHash = $tx;
            });
            Yii::info("sendSmartContract 9", 'own');
        } catch (Exception $e) {
            Yii::info("sendSmartContract error", 'own');
            Yii::info($e, 'own');
        }
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
            $this->_afterSuccessPayment($payment);
        }


        return $this->render('buyAfter', ['type' => $type, 'payment' => $payment, 'transactionHash' => $transactionHash]);
    }

    function _afterSuccessPayment($payment)
    {

        \Yii::info("_afterSuccessPayment", 'own');
        if (!$payment || $payment->status == Payment::STATUS_PAYMENT_CONFIRMED) {
            \Yii::info("_afterSuccessPayment STATUS_PAYMENT_CONFIRMED", 'own');
            return 'OK';
        }

        \Yii::info("_afterSuccessPayment 2", 'own');
        $payment->status = Payment::STATUS_PAYMENT_CONFIRMED;
        $payment->save();
        \Yii::info("_afterSuccessPayment 3", 'own');
        $project = $payment->project;
        $project->money += $payment->amount;
        $project->save();
        \Yii::info("_afterSuccessPayment 4", 'own');

        switch ($project->type) {
            case Project::TYPE_ECM:
                $transactionHash = $this->sendSmartContract($payment, $project, 'ECM');
                $transactionHash = $transactionHash . ',' . $this->sendSmartContract($payment, $project, 'SDT1', true);
                break;
            default:
                $transactionHash = $this->sendSmartContract($payment, $project, $project->token_name);
                break;

        }
        \Yii::info("_afterSuccessPayment 5 hash:" . $transactionHash, 'own');
        $payment->hash = $transactionHash;
        $payment->save();
    }


}
