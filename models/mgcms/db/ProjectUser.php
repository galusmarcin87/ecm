<?php

namespace app\models\mgcms\db;

use Yii;

/**
 * This is the base model class for table "project_user".
 *
 * @property integer $project_id
 * @property integer $user_id
 *
 * @property \app\models\mgcms\db\Project $project
 * @property \app\models\mgcms\db\User $user
 */
class ProjectUser extends \app\models\mgcms\db\AbstractRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_user';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => Yii::t('app', 'Project ID'),
            'user_id' => Yii::t('app', 'User ID'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\mgcms\db\User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\ProjectUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\ProjectUserQuery(get_called_class());
    }
}
