<?php

namespace app\models\mgcms\db;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \app\models\mgcms\db\MenuItem[] $children
 */
class Menu extends \app\models\mgcms\db\AbstractRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 245]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
      return $this->hasMany(\app\models\mgcms\db\MenuItem::className(), ['menu_id' => 'id'])->orderBy('`order` ASC')->where('parent_id IS NULL');
    }
    

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\MenuQuery(get_called_class());
    }
}
