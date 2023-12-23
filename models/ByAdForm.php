<?php

namespace app\models;

use Yii;
use yii\base\Model;
use \app\components\mgcms\MgHelpers;

/**
 * ContactForm is the model behind the contact form.
 */
class ByAdForm extends Model
{

    public $country;
    public $displayTime;
    public $fileId;
    public $image;
    public $link;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['country', 'displayTime', 'link'], 'required'],
            ['image', 'safe'],
            ['email', 'email'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'country' => Yii::t('db', 'Country'),
            'displayTime' => Yii::t('db', 'Display time'),
        ];
    }

}
