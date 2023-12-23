<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;
use yii\helpers\Html;

/**
 * This is the base model class for table "benefit".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property integer $company_id
 *
 * @property \app\models\mgcms\db\Company $company
 */
class Benefit extends \app\models\mgcms\db\AbstractRecord
{
    use LanguageBehaviorTrait;

    public $languageAttributes = ['description','name'];
    public $downloadFiles;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'company_id'], 'required'],
            [['description','price'], 'string'],
            [['company_id'], 'integer'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'benefit';
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
            'price' => Yii::t('app', 'Price'),
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
     * @return \app\models\mgcms\db\BenefitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\BenefitQuery(get_called_class());
    }

    public function getLinkUrl()
    {
        return \yii\helpers\Url::to(['/benefit/view', 'id' => $this->id, 'name' => $this->name]);
    }

    public function getLink()
    {
        return Html::a(Yii::t('db', 'See'), \yii\helpers\Url::to(['/benefit/view', 'id' => $this->id, 'name' => $this->name]));
    }
}
