<?php

namespace app\controllers;

//use \app\components\ZondaPayAPI;
use app\components\mgcms\tpay\TPayNotification;
use app\models\mgcms\db\User;
use app\models\SubscribeForm;
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


class ProjectController extends \app\components\mgcms\MgCmsController
{

    public function actionIndex($categoryId = false, $status = Project::STATUS_ACTIVE)
    {

        $query = Project::find()->where(['status' => $status]);
        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
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

        $loaded = $payment->load(Yii::$app->request->post());
        if ($loaded) {
            $saved = $payment->save();
            if (!$saved) {
                MgHelpers::setFlashError(Yii::t('db', 'Problem with saving payment ' . MgHelpers::getErrorsString($payment->errors)));
                return $this->redirect(['site/login']);
            }
            $payment->setModelAttribute('showUserName', $payment->showUserName);
            $payment->setModelAttribute('showUserPhoto', $payment->showUserPhoto);

            $config = [
                'amount' => $payment->amount,
                'description' => MgHelpers::getSettingTypeText('invest description' . Yii::$app->language, false, 'Zakup'),
                'crc' => (string)$payment->id,
                'result_url' => Url::to(['/project/notify', 'hash' => MgHelpers::encrypt(['payment_id' => $payment->id, 'project_id' => $project->id, 'user_id' => $user->id])], true),
                'result_email' => $user->email ?: $user->username,
                'return_url' => Url::to(['/project/buy-thank-you', 'hash' => MgHelpers::encrypt(['payment_id' => $payment->id, 'user_id' => $user->id])], true),
                'email' => $user->email ?: $user->username,
                'name' => (string)$user,
                'group' => isset($_POST['group']) ? (int)$_POST['group'] : 150,
                'accept_tos' => 1,
            ];


            try {
                $transactionSdk = new TPayTransaction(MgHelpers::getConfigParam('tpay'));
                $url = $transactionSdk->createRedirUrlForTransaction($config);
                return $this->redirect($url);
            } catch (Exception $e) {

            }
        }

        //--------------------------------STEP 2 ---------------------------------
        return $this->render('buy', ['project' => $project, 'payment' => $payment]);

    }

    public function beforeAction($action)
    {
        if ($action->id == 'notify') {
            $this->enableCsrfValidation = false;
        }
        return true;
    }

    public function actionNotify($hash)
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
        $project->money +=  $payment->amount;
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


    public function actionBuyTest()
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


}
