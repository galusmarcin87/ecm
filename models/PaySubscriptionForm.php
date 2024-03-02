<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;

/**
 * ContactForm is the model behind the contact form.
 */
class PaySubscriptionForm extends Model
{

    public $subscrriptionFee;
    public $exchangeRate;
    public $tokensAmount;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['subscrriptionFee', 'exchangeRate', 'tokensAmount'], 'required'],
            [['subscrriptionFee', 'exchangeRate', 'tokensAmount'], 'number'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'subscrriptionFee' => Yii::t('db', 'Subscription Fee'),
            'exchangeRate' => Yii::t('db', 'Exchange Rate'),
            'tokensAmount' => Yii::t('db', 'Tokens Amount'),
        ];
    }

}
