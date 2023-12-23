<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;
use yii\helpers\Html;

/**
 * This is the base model class for table "agent".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $position
 * @property string $description
 * @property string $phone
 * @property integer $file_id
 * @property integer $user_id
 * @property string $email
 * @property string $agentcol
 * @property integer $company_id
 *
 * @property \app\models\mgcms\db\Company $company
 * @property \app\models\mgcms\db\File $file
 * @property \app\models\mgcms\db\User $user
 */
class Agent extends \app\models\mgcms\db\AbstractRecord
{

    use LanguageBehaviorTrait;

    public $languageAttributes = ['description', 'position'];
    public $fileUpload;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],
            [['fileUpload'], 'safe'],
            [['description'], 'string'],
            [['file_id', 'company_id', 'user_id'], 'integer'],
            [['full_name', 'position', 'email'], 'string', 'max' => 245],
            [['phone', 'agentcol'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'agent';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full Name'),
            'position' => Yii::t('app', 'Position'),
            'description' => Yii::t('app', 'Description'),
            'phone' => Yii::t('app', 'Phone'),
            'file_id' => Yii::t('app', 'File ID'),
            'email' => Yii::t('app', 'Email'),
            'agentcol' => Yii::t('app', 'Agentcol'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\mgcms\db\User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\AgentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\AgentQuery(get_called_class());
    }

    public function getLinkUrl($type = 'info')
    {
        return \yii\helpers\Url::to(['/agent/view', 'name' =>  urlencode($this->user), 'id' => $this->id]);
    }

    public function getLink()
    {
        return Html::a(Yii::t('db', 'See'), \yii\helpers\Url::to(['/agent/view', 'name' =>  urlencode($this->user), 'id' => $this->id]));
    }
}
