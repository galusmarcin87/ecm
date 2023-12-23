<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;

/**
 * ContactForm is the model behind the contact form.
 */
class BecomeConsultantForm extends Model
{

    public $first_name;
    public $surname;
    public $email;
    public $phone;
    public $city;
    public $voivodeship;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['first_name', 'surname', 'email','phone','city','voivodeship'], 'required'],
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
            'first_name' => Yii::t('db', 'First Name'),
            'surname' => Yii::t('db', 'Surname'),
            'name' => Yii::t('db', 'Name and surname'),
            'email' => Yii::t('db', 'Email'),
            'phone' => Yii::t('db', 'Phone'),
            'city' => Yii::t('db', 'City'),
            'voivodeship' => Yii::t('db', 'Voivodeship'),
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
            Yii::$app->mailer->compose('becomeConsultant', ['model' => $this])
                ->setTo([MgHelpers::getSetting('email') => MgHelpers::getSetting('email nazwa')])
                ->setFrom([$this->email => $this->first_name.' '.$this->surname])
                ->setSubject('Zostań inwestorem')
                ->send();
            return true;
        }
        MgHelpers::setFlashError(Yii::t('app', 'Error during sending message, please correct form'));
        return false;
    }
}
