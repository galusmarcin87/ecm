<?php

namespace app\models;

use app\models\mgcms\db\File;
use app\models\mgcms\db\FileRelation;
use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;
use yii\validators\Validator;
use yii\web\UploadedFile;

/**
 * ContactForm is the model behind the contact form.
 */
class ReportRealEstateForm extends Model
{

    public $name;
    public $nip;
    public $pesel;
    public $surname;
    public $email;
    public $companyName;
    public $phone;
    public $body;
    public $localization;
    public $description;
    public $reCaptcha;
    public $acceptTerms;

    public $financePlan;
    public $estateType;
    public $campaignTime;
    public $minimalLoanAmount;
    public $maximalLoanAmount;
    public $intrestRate;

    public $uploadedFiles;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name',  'email', 'nip','phone','localization','estateType','financePlan','campaignTime','minimalLoanAmount','maximalLoanAmount','intrestRate'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            [['nip', 'pesel', 'phone', 'minimalLoanAmount', 'maximalLoanAmount', 'intrestRate'], 'integer'],
            [['phone', 'localization', 'estateType', 'financePlan', 'campaignTime', 'description'], 'safe'],
            [['uploadedFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, doc, docx, jpeg, calc', 'maxFiles' => 4],
            // verifyCode needs to be entered correctly
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => MgHelpers::getConfigParam('recaptcha')['secretKey']],
            //[['acceptTerms'], 'required', 'requiredValue' => 1, 'message' => Yii::t('db', 'This field is required')],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('db', 'Name of company / name and surname'),
            'pesel' => Yii::t('db', 'PESEL/KRS'),
            'surname' => Yii::t('db', 'Surname'),
            'email' => Yii::t('db', 'Email address'),
            'companyName' => Yii::t('db', 'Company name'),
            'phone' => Yii::t('db', 'Phone'),
            'body' => Yii::t('db', 'Real estate description'),
            'acceptTerms' => Yii::t('db', MgHelpers::getSettingTranslated('report_real_estate_accept_terms_text', 'I accept terms and conditions')),
            'verifyCode' => 'Verification Code',
            'localization' => Yii::t('db', 'Localization'),
            'estateType' => Yii::t('db', 'Real estate type'),
            'financePlan' => Yii::t('db', 'Finance plan'),
            'campaignTime' => Yii::t('db', 'Campaign time'),
            'minimalLoanAmount' => Yii::t('db', 'Minimal loan amount'),
            'maximalLoanAmount' => Yii::t('db', 'Maximal loan amount'),
            'intrestRate' => Yii::t('db', 'Intrest rate'),
            'description' => Yii::t('db', 'Description'),
        ];
    }


    public function sendMail()
    {

        if ($this->validate()) {

            $files = $this->uploadFiles();
            Yii::$app->mailer->compose('realEstateReport', ['model' => $this, 'files' => $files])
                ->setTo(MgHelpers::getSetting('real_estate_form_email'))
                ->setFrom([$this->email => $this->name . ' ' . $this->surname])
                ->setSubject(Yii::t('db', 'Real estate report'))
                ->send();
            MgHelpers::getSettingTranslated('contact_mail_notification', 'Thank you for contacting us');
            return true;
        }
        MgHelpers::setFlashError(Yii::t('app', 'Error during sending contact message, please correct form'));
        return false;
    }

    private function uploadFiles()
    {

        $upladedFiles = UploadedFile::getInstances($this, 'uploadedFiles');

        $files = [];
        if ($upladedFiles) {
            foreach ($upladedFiles as $CUploadedFileModel) {
                if ($CUploadedFileModel->hasError) {
                    MgHelpers::setFlash(MgHelpers::FLASH_TYPE_ERROR, Yii::t('app', 'Error with uploading file - probably file is too big'));
                    continue;
                }
                $fileModel = new File;
                $file = $fileModel->push(new \rmrevin\yii\module\File\resources\UploadedResource($CUploadedFileModel));
                if ($file) {
                    $files[] = $file;
                } else {
                    MgHelpers::setFlashError('Błąd dodawania pliku powiązanego');
                }
            }
            return $files;
        }
        return false;
    }

}
