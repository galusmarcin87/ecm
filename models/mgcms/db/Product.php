<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;
use yii\helpers\Html;

/**
 * This is the base model class for table "product".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_on
 * @property integer $category_id
 * @property string $description
 * @property string $specification
 * @property double $price
 * @property integer $number
 * @property integer $is_special_offer
 * @property string $special_offer_from
 * @property string $special_offer_to
 * @property integer $min_amount_of_purchase
 * @property double $special_offer_price
 * @property integer $company_id
 * @property string $link
 * @property string $linkUrl
 * @property integer $file_id
 * @property double $rating
 *
 * @property \app\models\mgcms\db\Category $category
 * @property \app\models\mgcms\db\Company $company
 * @property \app\models\mgcms\db\File $file
 * @property \app\models\mgcms\db\File $firstImage
 */
class Product extends \app\models\mgcms\db\AbstractRecord
{

    use LanguageBehaviorTrait;

    public $languageAttributes = ['description', 'specification', 'name'];

    public $downloadFiles;
    public $fileUpload;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'company_id', 'number', 'price', 'min_amount_of_purchase'], 'required'],
            [['created_on', 'special_offer_from', 'special_offer_to', 'fileUpload'], 'safe'],
            [['category_id', 'number', 'min_amount_of_purchase', 'company_id', 'file_id'], 'integer'],
            [['description', 'specification'], 'string'],
            [['special_offer_price'], 'number'],
            [['name', 'price',], 'string', 'max' => 245],
            [['is_special_offer'], 'integer', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created_on' => Yii::t('app', 'Created On'),
            'category_id' => Yii::t('app', 'Category'),
            'description' => Yii::t('app', 'Description'),
            'specification' => Yii::t('app', 'Specification'),
            'price' => Yii::t('app', 'Price'),
            'number' => Yii::t('app', 'Number'),
            'is_special_offer' => Yii::t('app', 'Is Special Offer'),
            'special_offer_from' => Yii::t('app', 'Special Offer From'),
            'special_offer_to' => Yii::t('app', 'Special Offer To'),
            'min_amount_of_purchase' => Yii::t('app', 'Min Amount Of Purchase'),
            'special_offer_price' => Yii::t('app', 'Special Offer Price'),
            'company_id' => Yii::t('app', 'Company'),
            'file_id' => Yii::t('app', 'File'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(\app\models\mgcms\db\Category::className(), ['id' => 'category_id']);
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
     * @return \app\models\mgcms\db\ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\ProductQuery(get_called_class());
    }

    public function getLinkUrl()
    {
        return \yii\helpers\Url::to(['/product/view', 'id' => $this->id, 'name' => urlencode($this->name)]);
    }

    public function getLink()
    {
        return Html::a(Yii::t('db', 'See'), \yii\helpers\Url::to(['/product/view', 'id' => $this->id, 'name' => urlencode($this->name)]));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'file_id']);
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
        $payment = Payment::find()->where(['user_id' => $user->id, 'rel_id' => $this->id, 'type' => 'Product'])->one();
        return $payment;

    }

    public function getRating()
    {
        $payments = Payment::find()->where(['rel_id' => $this->id, 'type' => 'Product'])->all();
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

    /**
     * @return File|void
     */
    public function getFirstImage(){
        foreach ($this->fileRelations as $relation){
            if ($relation->json !== '1' && $relation->file && $relation->file->isImage()){
                return $relation->file;
            }
        }

        return null;
    }

}
