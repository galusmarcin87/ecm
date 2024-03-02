<?php

namespace app\models\mgcms\db\base;
use rmrevin\yii\module\File\models;

use Yii;
use mootensai\behaviors\UUIDBehavior;

/**
 * This is the base model class for table "file".
 *
 * @property integer $id
 * @property string $mime
 * @property string $size
 * @property string $name
 * @property string $origin_name
 * @property string $sha1
 * @property integer $image_bad
 */
class File extends models\File
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['name'], 'file', 'skipOnEmpty' => false],
////            [['mime', 'name', 'origin_name', 'sha1'], 'required'],
//            [['size', 'image_bad'], 'integer'],
//            [['mime', 'name', 'origin_name'], 'string', 'max' => 255],
//            [['sha1'], 'string', 'max' => 40]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'mime' => Yii::t('app', 'Extension'),
            'size' => Yii::t('app', 'Size'),
            'name' => Yii::t('app', 'Name'),
            'origin_name' => Yii::t('app', 'Name'),
            'sha1' => Yii::t('app', 'Sha1'),
            'image_bad' => Yii::t('app', 'Image Bad'),
            'thumb' => Yii::t('app', 'Thumbnail'),
            'created_on' => Yii::t('app', 'Created On'),
        ];
    }


    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\FileQuery(get_called_class());
    }
    
   
    
   
}
