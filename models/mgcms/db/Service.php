<?php

namespace app\models\mgcms\db;

use app\components\mgcms\MgHelpers;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\helpers\Html;

/**
 * This is the base model class for table "service".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property string $description
 * @property string $specification
 * @property integer $company_id
 *
 * @property \app\models\mgcms\db\Company $company
 */
class Service extends \app\models\mgcms\db\AbstractRecord
{
    use LanguageBehaviorTrait;

    public $languageAttributes = ['description', 'specification'];

    public $downloadFiles;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'company_id', 'price'], 'required'],
            [['description', 'specification'], 'string'],
            [['company_id'], 'integer'],
            [['name','price'], 'string', 'max' => 245],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'price' => Yii::t('app', 'Price'),
            'description' => Yii::t('app', 'Description'),
            'specification' => Yii::t('app', 'Specification'),
            'company_id' => Yii::t('app', 'Company ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(\app\models\mgcms\db\Company::className(), ['id' => 'company_id']);
    }


    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\ServiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\ServiceQuery(get_called_class());
    }

    public function getLinkUrl()
    {
        return \yii\helpers\Url::to(['/service/view', 'id' => $this->id, 'name' => urlencode($this->name)]);
    }

    public function getLink()
    {
        return Html::a(Yii::t('db', 'See'), \yii\helpers\Url::to(['/service/view', 'id' => $this->id, 'name' => urlencode($this->name)]));
    }

    public function save($runValidaton = true, $attributes = null)
    {

        $saved = parent::save($runValidaton, $attributes);

//        if($saved){
//            $apiKey = MgHelpers::getSetting('stripe api key', false, 'sk_test_51FOmrVInHv9lYN6G23xLhzLTDNytsH8bOStCMPJ472ZAoutfeNag8DSuQswJkDmkpGPd1yRqqKtFfrrSb2ReZhtM00J3jbGTp0');
//            $stripe = new \Stripe\StripeClient(
//                $apiKey
//            );
//            $product = $stripe->products->create([
//                'name' => $this->name,
//                'default_price_data' => [
//                    'currency' => 'PLN',
//                    'unit_amount' => (int) ( $this->price * 100)
//                ]
//            ]);
//            $this->setModelAttribute('priceId',$product['default_price']);
//
//        }

        return $saved;
    }

    /**
     * @return false|Payment
     */
    public function getRatePayment()
    {
        $user = MgHelpers::getUserModel();
        if (!$user) {
            return false;
        }
        $payment = Payment::find()->where(['user_id' => $user->id, 'rel_id' => $this->id, 'type' => 'Service'])->one();
        return $payment;

    }

    public function getRating()
    {
        $payments = Payment::find()->where(['rel_id' => $this->id, 'type' => 'Service'])->all();
        $sum = 0;
        $max = 0;
        foreach ($payments as $payment) {
            if ($payment->rate) {
                $sum += $payment->rate;
                $max += 8;
            }
        }

        if ($max) {
            return number_format(($sum / $max) * 8, 2);
        } else {
            return 0;
        }

    }

}
