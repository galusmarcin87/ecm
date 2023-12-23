<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;

/**
 * ContactForm is the model behind the contact form.
 */
class InvestForm extends Model
{

    public $name;
    public $email;
    public $investitionAmount;
    public $phone;
    public $city;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'investitionAmount', 'phone', 'city'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
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
            'phone' => Yii::t('db', 'Phone'),
            'city' => Yii::t('db', 'city'),
            'investitionAmount' => Yii::t('db', 'Investition Amount'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function sendEmail()
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose('investForm', ['model' => $this])
                ->setTo([MgHelpers::getSetting('email') => MgHelpers::getSetting('email nazwa')])
                ->setFrom([$this->email => $this->name])
                ->setSubject('Informacje dla Inwestorów')
                ->send();

            return true;
        }
        MgHelpers::setFlashError(Yii::t('app', 'Error during sending contact message, please correct form'));
        return false;
    }
}
