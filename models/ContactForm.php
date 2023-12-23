<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{

    public $name;
    public $email;
    public $subject;
    public $phone;
    public $body;
    public $reCaptcha;
    public $acceptTerms;
    public $acceptTerms2;
    public $acceptTerms3;
    public $acceptTerms4;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['phone', 'safe'],
            // verifyCode needs to be entered correctly
//            [['reCaptcha'], \app\components\mgcms\recaptcha\ReCaptchaValidator::className()],
            //[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => MgHelpers::getConfigParam('recaptcha')['secretKey']],
            [['acceptTerms', 'acceptTerms2'], 'required', 'requiredValue' => 1, 'message' => Yii::t('db', 'This field is required')],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('db', 'Name and surname'),
            'email' => Yii::t('db', 'Email address'),
            'subject' => Yii::t('db', 'Subject'),
            'phone' => Yii::t('db', 'Phone'),
            'body' => Yii::t('db', 'Message'),
            'acceptTerms' => Yii::t('db', MgHelpers::getSettingTranslated('contact_accept_terms_text', 'I accept terms and conditions')),
            'acceptTerms2' => Yii::t('db', MgHelpers::getSettingTranslated('contact_accept_terms_text2', 'I accept rules')),
            'acceptTerms3' => Yii::t('db', MgHelpers::getSettingTranslated('contact_accept_terms_text3', 'I accept rules')),
            'acceptTerms4' => Yii::t('db', MgHelpers::getSettingTranslated('contact_accept_terms_text4', 'I accept rules')),
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {


            if (!$email) {
                MgHelpers::setFlashError(Yii::t('app', 'Recipient email is empty'));
                return false;
            }

            Yii::$app->mailer->compose('contact', ['model' => $this])
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject('Kontakt')
                ->send();
            MgHelpers::getSettingTranslated('contact_mail_notification', 'Thank you for contacting us');
            return true;
        }
        MgHelpers::setFlashError(Yii::t('app', 'Error during sending contact message, please correct form'));
        return false;
    }
}
