<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;

/**
 * ContactForm is the model behind the contact form.
 */
class NewsletterForm extends Model
{

    public $email;
    public $reCaptcha;
    public $acceptTerms;
    public $acceptTerms2;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['email'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['phone', 'safe'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator3::className(),
                'secret' => MgHelpers::getSetting('recaptcha secret key', false,'6LfzRZ0pAAAAAFsQDXGmzWPkipfhOq9AdoJK7uWw'), // unnecessary if reСaptcha is already configured
                'threshold' => 0.5,
                'action' => 'homepage',
            ],
            // verifyCode needs to be entered correctly
//            [['reCaptcha'], \app\components\mgcms\recaptcha\ReCaptchaValidator::className()],
            //[['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => MgHelpers::getConfigParam('recaptcha')['secretKey']],
            //[['acceptTerms', 'acceptTerms2'], 'required', 'requiredValue' => 1, 'message' => Yii::t('db', 'This field is required')],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('db', 'Email address'),
            'acceptTerms' => Yii::t('db', MgHelpers::getSettingTranslated('newsletter_accept_terms_text', 'I accept terms and conditions')),
            'acceptTerms2' => Yii::t('db', MgHelpers::getSettingTranslated('newsletter_accept_terms_text2', 'I accept rules')),
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function sendEmail($email)
    {
        if ($this->validate()) {
            if (!$email) {
                MgHelpers::setFlashError(Yii::t('app', 'Recipient email is empty'));
                return false;
            }

            $email = MgHelpers::getSetting('contact_email', false, 'mzielinska@vertes.pl');
            Yii::$app->mailer->compose('newsletter', ['email' => $this->email])
                ->setTo($email)
                ->setFrom([$email => $email])
                ->setSubject(Yii::t('db', 'Newsletter'))
                ->send();

            MgHelpers::getSettingTranslated('contact_mail_notification', 'Thank you for contacting us');
            return true;
        }
        MgHelpers::setFlashError(Yii::t('app', 'Error during sending contact message, please correct form'));
        return false;
    }
}
