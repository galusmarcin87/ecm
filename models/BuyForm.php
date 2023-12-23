<?php

namespace app\models;

use app\models\mgcms\db\Project;
use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;

/**
 * ContactForm is the model behind the contact form.
 */
class BuyForm extends Model
{

    public $amount;
    public $price;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['amount', 'price'], 'required'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'amount' => Yii::t('db', 'Amount'),
            'price' => Yii::t('db', 'Price'),
        ];
    }

}
