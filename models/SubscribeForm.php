<?php

namespace app\models;

use app\models\mgcms\db\Project;
use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;

/**
 * ContactForm is the model behind the contact form.
 */
class SubscribeForm extends Model
{

    public $email;
    public $reCaptcha;
    public $acceptTerms;


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
            // verifyCode needs to be entered correctly
//            [['reCaptcha'], \app\components\mgcms\recaptcha\ReCaptchaValidator::className()],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => MgHelpers::getConfigParam('recaptcha')['secretKey']],
            [['acceptTerms'], 'required', 'requiredValue' => 1, 'message' => Yii::t('db', 'This field is required')],
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
            'acceptTerms' => Yii::t('db', MgHelpers::getSettingTranslated('project_subscribe_accept_terms_text', 'project_subscribe_accept_terms_text')),
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * @param $project Project
     */
    public function subscribe($project){
        if ($this->validate()) {
            $emails = $project->getModelAttribute('emails');
            $project->setModelAttribute('emails', $emails . $this->email . ';');
            return true;
        }else{
            MgHelpers::setFlashError($this->getErrorSummary(true));
        }
    }

}
