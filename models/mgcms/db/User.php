<?php

namespace app\models\mgcms\db;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\IdentityInterface;
use \app\models\mgcms\db\base\User as BaseUser;
use kartik\password\StrengthValidator;
use app\components\mgcms\MgHelpers;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $role
 * @property integer $status
 * @property string $email
 * @property string $created_on
 * @property string $last_login
 * @property integer $created_by
 * @property string $address
 * @property string $postcode
 * @property string $birthdate
 * @property string $city
 * @property boolean $is_company
 * @property string $citizenship
 * @property string $pesel
 * @property string $birth_country
 * @property string $id_document_type
 * @property string $id_document_no
 * @property string $street
 * @property string $flat_no
 * @property string $phone
 * @property string $company_id
 * @property boolean $is_kyc_filled
 * @property string $language
 * @property string $country
 * @property string $type
 * @property string $company_name
 * @property string $company_nip
 * @property string $company_regon
 * @property string $company_country
 * @property string $company_voivodeship
 * @property string $company_postcode
 * @property string $company_city
 * @property string $company_street
 * @property string $company_house_no
 * @property string $company_flat_no
 * @property string $house_no
 * @property string $cor_first_name
 * @property string $cor_last_name
 * @property string $cor_country
 * @property string $cor_voivodeship
 * @property string $cor_postcode
 * @property string $cor_city
 * @property string $cor_street
 * @property string $cor_house_no
 * @property string $cor_flat_no
 * @property string $bank_no
 * @property string $step
 * @property integer $is_corespondence
 * @property integer $file_text
 * @property integer $acceptTerms5
 * @property integer $acceptTerms6
 * @property string $agent_code
 * @property string $testResult
 *
 *
 * @property User $createdBy
 * @property User[] $users
 * @property Payment[] $payments
 * @property Payment[] $paymentsApproved
 */
class User extends BaseUser implements IdentityInterface
{

    public $fileUpload;
    public $modelAttributes = ['facebook', 'twitter', 'linkedin', 'instagram', 'companyForSale', 'company_id', 'testResult'];
    public $languageAttributes = ['description', 'position'];


    const ROLE_ADMIN = 'admin';
    const ROLE_CLIENT = 'client';
    const ROLE_TEAM = 'team';
    const ROLE_PROJECT_OWNER = 'project owner';
    const ROLE_AGENT = 'agent';
    const ROLE_REPRESENTATIVE = 'representative';
    const ROLE_MANAGER = 'manager';
    const ROLE_SALES_DIRECTOR = 'sales director';

    const ROLE_INVESTOR_EXPERIENCED = 'investor_experienced';
    const ROLE_INVESTOR_EXPERIENCED_NOT_CONFIRMED = 'investor_experienced_not_confirmed';
    const ROLE_INVESTOR_NOT_EXPERIENCED = 'investor_not_experienced';
    const ROLE_WORKER = 'worker';
    const ROLE_WORKER_LIMITED = 'worker_limited';

    const ROLE_ROLE_1 = 'role_1';

    const ROLE_ROLE_2 = 'role_2';
    const   ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_INVESTOR_EXPERIENCED,
        self::ROLE_INVESTOR_EXPERIENCED_NOT_CONFIRMED,
        self::ROLE_INVESTOR_NOT_EXPERIENCED,
        self::ROLE_WORKER,
        self::ROLE_WORKER_LIMITED,
        self::ROLE_ROLE_1,
        self::ROLE_ROLE_2,
    ];
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const STATUS_VERIFIED = 2;
    const STATUS_SUSPENDED = 3;
    const STATUSES = [
        self::STATUS_ACTIVE => 'active',
        self::STATUS_INACTIVE => 'inactive',
        self::STATUS_VERIFIED => 'verified',
        self::STATUS_SUSPENDED => 'suspended',
    ];


    public $auths = false;
    public $passwordRepeat;
    public $oldPassword;

    public $acceptTerms;
    public $imAgentCheckbox = false;
    public $children = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required', 'except' => 'onAgent'],
            [['status', 'created_by', 'file_id', 'acceptTerms5', 'acceptTerms6', 'is_company'], 'integer'],
            [['created_on', 'last_login', 'birthdate', 'country', 'voivodeship', 'street', 'flat_no', 'citizenship', 'id_document_no', 'id_document_type', 'pesel', 'oldPassword'], 'safe'],
            [['username', 'password', 'first_name', 'last_name', 'email', 'address', 'postcode', 'city', 'cor_first_name', 'cor_last_name', 'cor_country', 'cor_voivodeship', 'cor_street', 'cor_flat_no', 'cor_house_no', 'cor_city', 'cor_postcode'], 'string', 'max' => 245],
            [['role', 'language'], 'string', 'max' => 45],
            [['username', 'auth_key'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['email'], 'email'],
            ['passwordRepeat', 'validateOldPassword', 'on' => 'passwordChanging'],
            [['password', 'oldPassword', 'passwordRepeat'], 'required', 'on' => 'passwordChanging'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('db', "Passwords don't match")],
//        [['password'], StrengthValidator::className(), 'min' => 8, 'digit' => 1, 'special' => 1, 'upper' => 1, 'lower' => 1, 'userAttribute' => 'username'],
            [['city', 'first_name', 'last_name', 'citizenship', 'pesel', 'birthdate', 'birth_country', 'document_type', 'street', 'house_no', 'flat_no', 'postcode', 'email', 'phone'], 'required', 'on' => 'kyc'],
            ['acceptTerms', 'required', 'requiredValue' => 1, 'message' => Yii::t('db', 'This field is required'), 'on' => 'account'],
            [['facebook', 'twitter', 'linkedin', 'instagram', 'phone', 'position', 'step', 'type', 'is_corespondence', 'house_no', 'companyForSale', 'agent_code', 'description'], 'safe'],
            [['first_name', 'last_name', 'linkedin', 'instagram', 'phone', 'position'], 'required', 'on' => 'person'],
            [['company_name', 'company_nip', 'company_regon', 'company_country', 'company_voivodeship', 'company_street', 'company_flat_no', 'company_house_no', 'company_city', 'company_postcode', 'bank_no'], 'safe'],
            [['file_text'], 'string'],
            [['imAgentCheckbox'], 'safe'],
            ['fileUpload', 'requiredForRepresentative', 'skipOnEmpty' => false,],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['created_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentsApproved()
    {
        return $this->hasMany(Payment::className(), ['user_id' => 'id'])->andWhere(['payment.status' => Payment::STATUS_PAYMENT_CONFIRMED]);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->setAuthKey();
        }
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord || strlen($this->password) != 60) {
            if (!$this->password && !$this->isNewRecord) {
                unset($this->password);
            } else {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            }
        }
        return parent::beforeSave($insert);
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function requiredForRepresentative($attribute)
    {
        if ($this->role == self::ROLE_REPRESENTATIVE && !$this->file_id) {
            $this->addError($attribute, Yii::t('db', 'Picture is required'));
        }
    }


    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validateSteps()
    {
        if (!$this->type) {
            $this->addError('type', 'type is required');
        }
    }


    private function setAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString(60);
    }

    public function updateLastLogin()
    {
        $this->last_login = new \yii\db\Expression('NOW()');
        $this->save();
    }

    public function getToString()
    {
        return $this->first_name ? $this->first_name . ' ' . $this->last_name : $this->username;
    }

    public function __toString()
    {
        return $this->getToString();
    }

    public function checkAccess($controller, $action, $role = false)
    {
        if (!$role) {
            $role = $this->role;
        }

        $allowedActions = array('logout', 'login');
        $allowedContollers = array();
        $allowedContollerWithAction = array('defaultindex');

        if (in_array($controller, $allowedContollers) || in_array($action, $allowedActions) || in_array($controller . $action, $allowedContollerWithAction)) {
            return true;
        }
        if (!$this->auths) {
            $this->auths = Auth::find()->asArray()->all();
        }

        $authFound = false;
        foreach ($this->auths as $auth) {
            if ($auth['controller'] == $controller && $auth['action'] == $action && $auth['role'] === $role) {
                $authFound = $auth;
            }
        }

        if (!$authFound) {
            $auth = new Auth;
            $auth->controller = $controller;
            $auth->action = $action;
            $auth->role = $role;
            $auth->value = 0;
            $auth->save();
            if ($role == User::ROLE_ADMIN) {
                return true;
            }
            return false;
        } else {
            if ($role == User::ROLE_ADMIN) {
                return true;
            }
            return $authFound['value'];
        }

        return false;
    }

    public function getStatusStr()
    {
        return Yii::t('app', self::STATUSES[$this->status]);
    }

    public function save($runValidaton = true, $attributes = null)
    {
        if ($this->language) {
            Yii::$app->language = $this->language;
        }
//        if ($this->getOldAttribute('status') != self::STATUS_SUSPENDED && $this->getAttribute('status') == self::STATUS_SUSPENDED) {
//
//            Yii::$app->mailer->compose('suspendedAccount', ['model' => $this])
//                ->setTo($this->username)
//                ->setFrom([MgHelpers::getSetting('register_email') => MgHelpers::getSetting('register_email_name')])
//                ->setSubject(MgHelpers::getSettingTranslated('user_account_suspended_mail_subject', 'Your account has been suspended'))
//                ->send();
//        }
//
//        if ($this->getOldAttribute('status') == self::STATUS_ACTIVE && $this->getAttribute('status') == self::STATUS_VERIFIED) {
//
//            Yii::$app->mailer->compose('verifiedAccount', ['model' => $this])
//                ->setTo($this->username)
//                ->setFrom([MgHelpers::getSetting('register_email') => MgHelpers::getSetting('register_email_name')])
//                ->setSubject(MgHelpers::getSettingTranslated('user_account_verified_mail_subject', 'Your account has been verified'))
//                ->send();
//        }
//
//        if ($this->getOldAttribute('status') == self::STATUS_SUSPENDED && $this->getAttribute('status') == self::STATUS_VERIFIED) {
//
//            Yii::$app->mailer->compose('reverifiedAccount', ['model' => $this])
//                ->setTo($this->username)
//                ->setFrom([MgHelpers::getSetting('register_email') => MgHelpers::getSetting('register_email_name')])
//                ->setSubject(MgHelpers::getSettingTranslated('user_account_verified_mail_subject', 'Your account has been reverified'))
//                ->send();
//        }

        if ($this->getOldAttribute('agent_code') && $this->getOldAttribute('agent_code') != $this->agent_code) {
            $companies = Company::find()->where(['agent_code' => $this->getOldAttribute('agent_code')])->all();

            foreach ($companies as $company) {
                $company->agent_code = $this->agent_code;
                $company->save();
            }
        }

        if ($this->agent_code) {
            $reflinkUser = User::find()->where(['agent_code' => $this->agent_code])->one();
            if ($reflinkUser) {
                $this->created_by = $reflinkUser->id;
            }
        }

        if (!$this->agent_code) {
            $this->agent_code = bin2hex(random_bytes(10));
        }

        return parent::save($runValidaton, $attributes);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'file_id']);
    }

    public function validateOldPassword()
    {
        if ($this->passwordRepeat) {
            if (!$this->oldPassword) {
                $this->addError('oldPassword', Yii::t('db', 'Old passowd missing'));
            }
            try {
                $this->validatePassword($this->oldPassword);
            } catch (InvalidArgumentException $e) {
                $this->addError('oldPassword', Yii::t('db', 'Wrong password'));
            }

            return true;

        }
    }

    public function isAdmin()
    {

        return $this->role == self::ROLE_ADMIN;
    }

    public function getRolesManagableForUser()
    {
        switch ($this->role) {
            case self::ROLE_AGENT:
                return [self::ROLE_CLIENT];
            case self::ROLE_MANAGER:
                return [self::ROLE_AGENT, self::ROLE_CLIENT];
            case self::ROLE_SALES_DIRECTOR:
                return [self::ROLE_AGENT, self::ROLE_MANAGER, self::ROLE_CLIENT];
            case self::ROLE_ADMIN:
                return self::ROLES;
        }
    }
}
