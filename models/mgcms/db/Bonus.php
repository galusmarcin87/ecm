<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;

/**
 * This is the base model class for table "bonus".
 *
 * @property integer $id
 * @property integer $from
 * @property integer $to
 * @property integer $value
 * @property integer $project_id
 *
 * @property \app\models\mgcms\db\Project $project
 */
class Bonus extends \app\models\mgcms\db\AbstractRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'value', 'project_id'], 'required'],
            [['to', 'project_id'], 'integer'],
            [['from'], 'string', 'max' => 255],
            [['value'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bonus';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from' => Yii::t('app', 'Nagłówek'),
            'to' => Yii::t('app', 'Do'),
            'value' => Yii::t('app', 'Tekst'),
            'project_id' => Yii::t('app', 'Project'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(\app\models\mgcms\db\Project::className(), ['id' => 'project_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\BonusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\BonusQuery(get_called_class());
    }
}
