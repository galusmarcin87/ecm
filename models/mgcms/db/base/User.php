<?php

namespace app\models\mgcms\db\base;

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\LanguageBehaviorTrait;
use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "user".
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
 * @property string $auth_key
 * @property string $file_id
 * @property string $country
 * @property string $voivodeship
 * @property string $street
 * @property string $flat_no
 * @property string $citizenship
 * @property string $id_document_type
 * @property string $id_document_no
 * @property string $pesel
 *
 * @property \app\models\mgcms\db\User $createdBy
 * @property \app\models\mgcms\db\User[] $users
 * @property \app\models\mgcms\db\File $file
 */
class User extends \app\models\mgcms\db\AbstractRecord
{

    use LanguageBehaviorTrait;

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
  public function attributeLabels()
  {
    return [
        'id' => Yii::t('db', 'ID'),
        'username' => Yii::t('db', 'E-mail address'),
        'password' => Yii::t('db', 'Password'),
        'first_name' => Yii::t('db', 'First Name'),
        'last_name' => Yii::t('db', 'Last Name'),
        'role' => Yii::t('db', 'Role'),
        'status' => Yii::t('db', 'Status'),
        'statusStr' => Yii::t('db', 'Status'),
        'email' => Yii::t('db', 'Email'),
        'created_on' => Yii::t('db', 'Created On'),
        'last_login' => Yii::t('db', 'Last Login'),
        'created_by' => Yii::t('db', 'Created By'),
        'createdBy' => Yii::t('db', 'Created By'),
        'address' => Yii::t('db', 'Address'),
        'postcode' => Yii::t('db', 'Postcode'),
        'birthdate' => Yii::t('db', 'Birthdate'),
        'city' => Yii::t('db', 'City'),
        'is_company' => Yii::t('db', 'Is company?'),
        'citizenship' => Yii::t('db', 'Citizenship'),
        'pesel' => Yii::t('db', 'Pesel'),
        'birth_country' => Yii::t('db', 'Birth country'),
        'document_type' => Yii::t('db', 'Type of identity document'),
        'street' => Yii::t('db', 'Street'),
        'house_no' => Yii::t('db', 'House number'),
        'flat_no' => Yii::t('db', 'Flat number'),
        'file_id' => Yii::t('db', 'File'),
        'phone' => Yii::t('db', 'Phone'),
        'company_name' => Yii::t('db', 'Company name'),
        'company_id' => Yii::t('db', 'Company identifier'),
        'passwordRepeat' => Yii::t('db', 'Repeat password'),
        'id_document_type' => Yii::t('db', 'Identity document kind'),
        'id_document_no' => Yii::t('db', 'Identity document number'),
        'voivodeship' => Yii::t('db', 'Voivodeship'),
        'acceptTerms' => MgHelpers::getSettingTranslated('account_terms_label', 'Zgoda na ....'),
        'country' => Yii::t('db', 'Country'),
        'oldPassword' => Yii::t('db', 'Old password'),
        'position' => Yii::t('db', 'Position'),
        'cor_first_name' => Yii::t('db', 'First Name'),
        'cor_last_name' => Yii::t('db', 'Last Name'),
        'cor_postcode' => Yii::t('db', 'Postcode'),
        'cor_city' => Yii::t('db', 'City'),
        'birth_country' => Yii::t('db', 'Birth country'),
        'document_type' => Yii::t('db', 'Type of identity document'),
        'cor_street' => Yii::t('db', 'Street'),
        'cor_house_no' => Yii::t('db', 'House number'),
        'cor_flat_no' => Yii::t('db', 'Flat number'),
        'cor_voivodeship' => Yii::t('db', 'Voivodeship'),
        'cor_country' => Yii::t('db', 'Country'),

        'company_name' => Yii::t('db', 'Company name'),
        'company_regon' => Yii::t('db', 'REGON'),
        'company_nip' => Yii::t('db', 'NIP'),
        'company_street' => Yii::t('db', 'Street'),
        'company_house_no' => Yii::t('db', 'House number'),
        'company_flat_no' => Yii::t('db', 'Flat number'),
        'company_voivodeship' => Yii::t('db', 'Voivodeship'),
        'company_country' => Yii::t('db', 'Country'),
        'company_postcode' => Yii::t('db', 'Postcode'),
        'company_city' => Yii::t('db', 'City'),
        'file_text' => 'Pliki oddzielane enterem, nazwa;link',
        'imAgentCheckbox' => Yii::t('db', 'I am agent'),
        'agent_code' => Yii::t('db', 'Agent code'),
        'testResult' => Yii::t('db', 'Test result'),
    ];
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
    public function getUsers()
    {
        return $this->hasMany(\app\models\mgcms\db\User::className(), ['created_by' => 'id']);
    }


    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\UserQuery(get_called_class());
    }
}
