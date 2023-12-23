<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;

/**
 * This is the base model class for table "ad".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property string $date_to
 * @property string $country
 * @property integer $file_id
 * @property integer $link
 *
 * @property \app\models\mgcms\db\File $file
 */
class Ad extends \app\models\mgcms\db\AbstractRecord
{
    const STATUS_NEW = 'new';
    const STATUS_PAID = 'paid';
    const STATUS_APPROVED = 'approved';


    const STATUSES = [
        self::STATUS_NEW => 'nowy',
        self::STATUS_PAID => 'opłacony',
        self::STATUS_APPROVED => 'zatwierdzony',
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_to'], 'safe'],
            [['file_id'], 'integer'],
            [['name', 'country', 'link'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'status' => Yii::t('app', 'Status'),
            'date_to' => Yii::t('app', 'Date To'),
            'country' => Yii::t('app', 'Country'),
            'file_id' => Yii::t('app', 'File ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(\app\models\mgcms\db\File::className(), ['id' => 'file_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\AdQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\AdQuery(get_called_class());
    }
}
