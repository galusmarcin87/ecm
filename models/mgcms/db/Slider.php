<?php

namespace app\models\mgcms\db;

use Yii;
use app\components\mgcms\MgHelpers;

/**
 * This is the base model class for table "slider".
 *
 * @property integer $id
 * @property string $name
 * @property string $language
 *
 * @property \app\models\mgcms\db\Slide[] $slides
 */
class Slider extends \app\models\mgcms\db\AbstractRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 245],
            [['language'], 'string', 'max' => 45]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'language' => Yii::t('app', 'Language'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSlides()
    {
        return $this->hasMany(\app\models\mgcms\db\Slide::className(), ['slider_id' => 'id'])->orderBy('order' );
    }
    
    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\SliderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\SliderQuery(get_called_class());
    }
}
