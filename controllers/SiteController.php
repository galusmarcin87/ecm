<?php

namespace app\controllers;

use _;
use app\models\BecameConsultantForm;
use app\models\BecomeConsultantForm;
use app\models\InvestForm;
use app\models\ByAdForm;
use app\models\LoginCodeForm;
use app\models\mgcms\db\Ad;
use app\models\mgcms\db\Company;
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

class SiteController extends \app\components\mgcms\MgCmsController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $contactForm = new ContactForm();

        if ($contactForm->load(Yii::$app->request->post()) && $contactForm->contact(Yii::$app->params['adminEmail'])) {
            MgHelpers::setFlashSuccess(Yii::t('db', 'Mail has been sent'));
            return $this->refresh();
        }


        /* -----------  SEO  ------------ */
        Yii::$app->view->title = MgHelpers::getSettingTranslated('SEO_title_home_page_' . Yii::$app->language, Yii::$app->name);
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => MgHelpers::getSettingTranslated('SEO_description_home_page_' . Yii::$app->language)
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => MgHelpers::getSettingTranslated('SEO_keywords_home_page_' . Yii::$app->language)
        ]);
        /* -----------  SEO  ------------ */


        return $this->render('index', [
            'contactForm' => $contactForm
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionRegister($agentCode = false)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($agentCode) {
            $model->agentCode = $agentCode;
        }
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            MgHelpers::setFlashSuccess(MgHelpers::getSettingTranslated('register_after_message',
                'Thank you for registration, email with activation of account has been sent.'));
            return $this->refresh();
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }


    public function actionForgotPassword()
    {
        $model = new \app\models\ForgotPasswordForm();
        if ($model->load(Yii::$app->request->post()) && $model->sendMail()) {
            \app\components\mgcms\MgHelpers::setFlashSuccess(Yii::t('db', 'Forgot Password email has been sent'));
            return $this->goBack();
        }
        return $this->render('forgotPassword', [
            'model' => $model
        ]);
    }

    public function actionForgotPasswordChange($hash)
    {
        $email = \app\components\mgcms\MgHelpers::decrypt($hash);
        if (!$email) {
            $this->throw404();
        }
        $user = User::find()->where(['username' => $email])->one();
        if (!$user) {
            $this->throw404();
        }

        $model = new \app\models\ResetPasswordForm($user);
        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            \app\components\mgcms\MgHelpers::setFlashSuccess(Yii::t('db', 'Password has been changed'));
            return $this->goBack();
        }
        return $this->render('resetPassword', [
            'model' => $model
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            MgHelpers::setFlashSuccess(Yii::t('db', 'Mail has been sent'));

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $loginCodeForm = new LoginCodeForm();


        if ($model->load(Yii::$app->request->post()) && $model->login2step()) {
            $loginCodeForm->userId = $model->getUser()->id;
            if ($this->_sendLoginConfirmationCodeEmail($model, $loginCodeForm)) {
                $loginCodeForm->userId = $model->getUser()->id;
                $loginCodeForm->rememberMe = $model->rememberMe;
                return $this->render('loginCode', [
                    'model' => $model,
                    'loginCodeForm' => $loginCodeForm
                ]);
            } else {
                MgHelpers::setFlashError(MgHelpers::getSettingTranslated('login_error_email', 'Problem with sending email'));
                return $this->goHome();
            }
        }

        if ($loginCodeForm->load(Yii::$app->request->post())) {
            if ($loginCodeForm->verifyCode() && $loginCodeForm->login()) {
                return $this->redirect('/account/index');
            } else {
                return $this->render('loginCode', [
                    'model' => $model,
                    'loginCodeForm' => $loginCodeForm
                ]);
            }
        }


        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @param $loginForm LoginForm
     * @param $loginForm LoginCodeForm
     */
    private function _sendLoginConfirmationCodeEmail($loginForm, $loginCodeForm)
    {
        /**
         * @var $model User
         */
        $user = $loginForm->getUser();

        if (!$user) {
            return false;
        }

        $code = $loginCodeForm->generateCode();

        $mailer = Yii::$app->mailer->compose('loginCode', ['user' => $user, 'code' => $code])
            ->setTo($user->email ? $user->email : $user->username)
            //->setTo('galusmarcin87@gmail.com')
            ->setFrom([MgHelpers::getSetting('email') => MgHelpers::getSetting('email nazwa')])
            ->setSubject(Yii::t('db', 'Login code'));

        return $mailer->send();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionKnowledgeBase()
    {
        return $this->render('knowledgeBase');
    }

    public function actionActivate($hash)
    {

        $id = MgHelpers::decrypt($hash);
        if (!$id) {
            $this->throw404();
        }

        $user = User::findOne($id);
        if (!$user) {
            $this->throw404();
        }

        $user->status = User::STATUS_ACTIVE;
        $saved = $user->save();
        if ($saved) {
            MgHelpers::setFlashSuccess(Yii::t('db', 'Successfull activation'));
            $this->redirect('/');
        }
    }

    public function actionMetrics($hash)
    {
        $id = MgHelpers::decrypt($hash);
        if (!$id) {
            $this->throw404();
        }

        $payment = Payment::findOne($id);

        if (!$payment || !$this->getUserModel()) {
            $this->throw404();
        }
        if ($payment->user_id !== $this->getUserModel()->id) {
            $this->throw404();
        }
        if (!in_array($payment->status, [Payment::STATUS_PAYMENT_CONFIRMED, Payment::STATUS_PAYMENT_CONFIRMED])) {
            $this->throw404();
        }


        return $this->renderPartial('certificate', [
                'model' => $payment
            ]
        );
    }

    public function actionAccount($backUrl = false)
    {


        $model = $this->getUserModel();

        if (!$model) {
            $this->throw404();
        }

//        if ($this->getUserModel()->status != User::STATUS_VERIFIED) {
//            return $this->redirect(['site/fill-account']);
//        }


        $model->scenario = 'account';
        if ($backUrl) {
            $model->scenario = 'kyc';
        }


        if (Yii::$app->request->post('User')) {
            if (Yii::$app->request->post('passwordChanging')) {
                $model->scenario = 'passwordChanging';
            }

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if ($backUrl) {
                    $model->is_kyc_filled = 1;
                    $saved = $model->save();
                    if ($saved) {
                        return $this->redirect([$backUrl]);
                    }
                } else {
                    MgHelpers::setFlashSuccess(Yii::t('db', 'Saved succesfully'));
                }
            }
        }

        if (Yii::$app->request->post('imageSave') === '') {
            $upladedFiles = UploadedFile::getInstance($model, 'file_id');
            if ($upladedFiles) {
                $fileModel = new File;
                $file = $fileModel->push(new \rmrevin\yii\module\File\resources\UploadedResource($upladedFiles));
                if ($file) {
                    $model->file_id = $file->id;
                    $saved = $model->save();
                }

            }
        }


        return $this->render('account', [
            'model' => $model,
            'backProject' => $backUrl
        ]);
    }

    public function actionRemovePhoto()
    {
        $model = $this->getUserModel();
        $model->file_id = null;
        $model->save();
        $this->back();
    }

    public function actionSearch($q)
    {

        $query = Article::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_on' => SORT_DESC]]
        ]);


        $query->orWhere(['like', 'title', $q]);

        return $this->render('search', [
            'dataProvider' => $dataProvider
        ]);
    }

    private function _renderQuestion($options, $answerPost)
    {
        $str = '';
        extract($options);
        $str .= '<p>' . ($questionIndex + 1) . '.' . ($isSubquestion ? ($subQuestionIndex + 1) . '.' : '') . $question['question'] . '</p>';


        if ($isSubquestion) {
            $subquestionAnswersPost = Yii::$app->request->post('AnswerSubquestion');
            $answer = _::get($subquestionAnswersPost, [(string)$sectionIndex, (string)$questionIndex, (string)$subQuestionIndex]);

        } else {
            $answer = _::get($answerPost, [(string)$sectionIndex, (string)$questionIndex]);
        }

        if ($answer !== NULL) {
            if (is_array($answer)) {
                foreach ($answer as $answerItem) {
                    $str .= _::get($question, 'answers.' . $answerItem) . ',';
                }

            } else {
                $str .= _::get($question, 'answers.' . $answer);
            }
        }


        if (isset($question['subquestions'])) {
            foreach ($question['subquestions'] as $subQuestionIndex => $subQuestion) {
                $str .= $this->_renderQuestion([
                    'sectionIndex' => $sectionIndex,
                    'questionIndex' => $questionIndex,
                    'question' => $subQuestion,
                    'subQuestionIndex' => $subQuestionIndex,
                    'isSubquestion' => true,
                ], $answerPost);
            }
        }


        return $str;

    }

    public function actionKnowledgeTest()
    {
        $config = MgHelpers::getConfigParam('knowledgeTest');

        if (Yii::$app->request->post('Answer')) {
            $answers = Yii::$app->request->post('Answer');
            $strToSave = '';
            foreach ($config['sections'] as $sectionIndex => $section) {
                $strToSave .= '<h2>' . $section['name'] . '</h2>';
                foreach ($section['questions'] as $questionIndex => $question) {
                    $strToSave .= $this->_renderQuestion([
                        'sectionIndex' => $sectionIndex,
                        'questionIndex' => $questionIndex,
                        'question' => $question,
                        'subQuestionIndex' => false,
                        'isSubquestion' => false,
                    ], $answers);

                }
            }
            $user = $this->getUserModel();
            $user->testResult = $strToSave;
            $user->role = User::ROLE_INVESTOR_EXPERIENCED_NOT_CONFIRMED;
            $saved = $user->save();
            if($saved){
                MgHelpers::setFlashSuccess(Yii::t('db','Knowledge test saved'));
                return $this->redirect('/');
            }


        }
        return $this->render('knowledgeTest', [
            'config' => $config
        ]);
    }


    public function actionGetCapital(){
        return $this->render('getCapital', [

        ]);
    }


    public function actionCompleteAttorney(){
        return $this->render('completeAttorney', [

        ]);
    }

    public function actionInvest(){
        return $this->render('invest', [

        ]);
    }
}
