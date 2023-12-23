<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;
use yii\helpers\Html;

/**
 * This is the base model class for table "company".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $is_promoted
 * @property string $first_name
 * @property string $surname
 * @property string $status
 * @property string $country
 * @property string $city
 * @property string $postcode
 * @property string $street
 * @property string $phone
 * @property string $email
 * @property string $www
 * @property string $nip
 * @property string $regon
 * @property string $krs
 * @property string $banc_account_no
 * @property string $gps_lat
 * @property string $gps_long
 * @property double $subscription_fee
 * @property string $companycol
 * @property integer $created_by
 * @property string $created_on
 * @property integer $category_id
 * @property integer $user_id
 * @property string $payment_status
 * @property string $paid_from
 * @property string $paid_to
 * @property integer $thumbnail_id
 * @property integer $background_id
 * @property integer $is_for_sale
 * @property string $sale_title
 * @property string $sale_description
 * @property double $sale_price
 * @property string $sale_currency
 * @property string $sale_price_includes
 * @property string $sale_reason
 * @property string $sale_business_range
 * @property integer $sale_workers_number
 * @property string $sale_sale_range
 * @property double $sale_last_year_income
 * @property string $sale_company_profile
 * @property string $sale_form_of_business
 * @property integer $is_institution
 * @property string $institution_agent_prefix
 * @property double $institution_invoice_amount
 * @property string $link
 * @property string $linkUrl
 * @property string $agent_code
 * @property integer $benefit
 * @property string $stripe_price_id
 * @property string $looking_for
 *
 * @property \app\models\mgcms\db\Agent[] $agents
 * @property \app\models\mgcms\db\Benefit[] $benefits
 * @property \app\models\mgcms\db\Category $category
 * @property \app\models\mgcms\db\File $thumbnail
 * @property \app\models\mgcms\db\File $background
 * @property \app\models\mgcms\db\User $createdBy
 * @property \app\models\mgcms\db\User $user
 * @property \app\models\mgcms\db\Company $institution
 * @property \app\models\mgcms\db\Company[] $institutionCompanies
 * @property \app\models\mgcms\db\User[] $users
 * @property \app\models\mgcms\db\Job[] $jobs
 * @property \app\models\mgcms\db\Product[] $products
 * @property \app\models\mgcms\db\Service[] $services
 */
class Company extends \app\models\mgcms\db\AbstractRecord
{
    use LanguageBehaviorTrait;

    public $languageAttributes = ['description', 'sale_description', 'sale_title', 'sale_price_includes', 'sale_reason', 'city'];
    public $modelAttributes = ['video', 'video_thumbnail'];

    public $downloadFiles;
    public $logosFiles;
    public $viewType;
    public $backgroundFile;
    public $thumbnailFile;


    const STATUS_NEW = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_INACTIVE = 3;
    const STATUSES = [self::STATUS_NEW => 'nowy', self::STATUS_CONFIRMED => 'potwierdzony', self::STATUS_INACTIVE => 'nieaktywny'];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'first_name', 'surname', 'country', 'city', 'postcode', 'street', 'phone', 'email', 'nip', 'regon', 'category_id', 'user_id'], 'required'],
            [['description', 'sale_description', 'sale_price_includes', 'sale_reason', 'sale_form_of_business', 'looking_for'], 'string'],
            [['gps_lat', 'gps_long', 'subscription_fee', 'sale_price', 'sale_last_year_income', 'institution_invoice_amount'], 'number'],
            [['created_by', 'category_id', 'user_id', 'thumbnail_id', 'background_id', 'sale_workers_number', 'company_id'], 'integer'],
            [['created_on', 'paid_from', 'paid_to', 'video', 'video_thumbnail', 'backgroundFile', 'thumbnailFile'], 'safe'],
            [['name', 'first_name', 'surname', 'email', 'www', 'sale_title', 'sale_business_range', 'sale_sale_range', 'stripe_price_id'], 'string', 'max' => 245],
            [['is_promoted', 'is_for_sale', 'is_institution', 'is_benefit'], 'integer', 'max' => 1],
            [['status', 'country', 'city', 'postcode', 'street', 'banc_account_no', 'companycol', 'payment_status', 'sale_company_profile', 'institution_agent_prefix', 'companycol1'], 'string', 'max' => 45],
            [['phone', 'nip', 'regon', 'krs', 'sale_currency'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'is_promoted' => Yii::t('app', 'Is Promoted'),
            'first_name' => Yii::t('app', 'First Name'),
            'surname' => Yii::t('app', 'Surname'),
            'status' => Yii::t('app', 'Status'),
            'country' => Yii::t('app', 'Country'),
            'city' => Yii::t('app', 'City'),
            'postcode' => Yii::t('app', 'Postcode'),
            'street' => Yii::t('app', 'Street'),
            'phone' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'www' => Yii::t('app', 'Www'),
            'nip' => Yii::t('app', 'Nip'),
            'regon' => Yii::t('app', 'Regon'),
            'krs' => Yii::t('app', 'Krs'),
            'banc_account_no' => Yii::t('app', 'Bank Account No'),
            'gps_lat' => Yii::t('app', 'Gps Lat'),
            'gps_long' => Yii::t('app', 'Gps Long'),
            'subscription_fee' => Yii::t('app', 'Subscription Fee'),
            'created_on' => Yii::t('app', 'Companycol'),
            'created_by' => Yii::t('app', 'Created By'),
            'category_id' => Yii::t('app', 'Category'),
            'user_id' => Yii::t('app', 'User'),
            'payment_status' => Yii::t('app', 'Payment Status'),
            'paid_from' => Yii::t('app', 'Paid From'),
            'paid_to' => Yii::t('app', 'Paid To'),
            'thumbnail_id' => Yii::t('app', 'Thumbnail'),
            'background_id' => Yii::t('app', 'Background'),
            'is_for_sale' => Yii::t('app', 'Is For Sale'),
            'sale_title' => Yii::t('app', 'Sale Title'),
            'sale_description' => Yii::t('app', 'Sale Description'),
            'sale_price' => Yii::t('app', 'Sale Price'),
            'sale_currency' => Yii::t('app', 'Sale Currency'),
            'sale_price_includes' => Yii::t('app', 'Sale Price Includes'),
            'sale_reason' => Yii::t('app', 'Sale Reason'),
            'sale_business_range' => Yii::t('app', 'Sale Business Range'),
            'sale_workers_number' => Yii::t('app', 'Sale Workers Number'),
            'sale_sale_range' => Yii::t('app', 'Sale Sale Range'),
            'sale_last_year_income' => Yii::t('app', 'Sale Last Year Income'),
            'sale_company_profile' => Yii::t('app', 'Sale Company Profile'),
            'sale_form_of_business' => Yii::t('app', 'Sale Form Of Business'),
            'is_institution' => Yii::t('app', 'Is Institution'),
            'institution_agent_prefix' => Yii::t('app', 'Institution Agent Prefix'),
            'institution_invoice_amount' => Yii::t('app', 'Institution Invoice Amount'),
            'companycol1' => Yii::t('app', 'Companycol1'),
            'is_benefit' => Yii::t('app', 'Is Benefit'),
            'stripe_price_id' => Yii::t('app', 'Stripe Price ID'),
            'company_id' => Yii::t('app', 'Institution'),
            'looking_for' => Yii::t('app', 'Looking for'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgents()
    {
        return $this->hasMany(\app\models\mgcms\db\Agent::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBenefits()
    {
        return $this->hasMany(\app\models\mgcms\db\Benefit::className(), ['company_id' => 'id']);
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
    public function getInstitution()
    {
        return $this->hasOne(\app\models\mgcms\db\Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThumbnail()
    {
        return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'thumbnail_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBackground()
    {
        return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'background_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(\app\models\mgcms\db\User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\mgcms\db\User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJobs()
    {
        return $this->hasMany(\app\models\mgcms\db\Job::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionCompanies()
    {
        return $this->hasMany(\app\models\mgcms\db\Company::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(\app\models\mgcms\db\Product::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(\app\models\mgcms\db\Service::className(), ['company_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\CompanyQuery(get_called_class());
    }

    public function getLinkUrl($type = 'info')
    {
        return \yii\helpers\Url::to(['/company/view', 'name' => str_replace('/', '___', $this->name), 'id' => $this->id, 'type' => $type]);
    }

    public function getLink()
    {
        return Html::a(Yii::t('db', 'See'), \yii\helpers\Url::to(['/company/view', 'name' => str_replace('/', '___', $this->name), 'id' => $this->id]));
    }

    public function beforeSave($insert)
    {
        $currentUser = MgHelpers::getUserModel();
        if (!$currentUser->isAdmin()) {
            $this->user_id = $currentUser->id;
            $this->agent_code = $currentUser->agent_code;
        }


        return parent::beforeSave($insert);
    }

    /**
     * @return false|Payment
     */
    public function getRatePayment()
    {
        return false;

    }

    public function getRating()
    {
        $payments = Payment::find()->where(['company_id' => $this->id])->all();
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
