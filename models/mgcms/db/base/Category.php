<?php

namespace app\models\mgcms\db\base;

use Yii;
use mootensai\behaviors\UUIDBehavior;


class Category extends \app\models\mgcms\db\AbstractRecord
{

    public $onlyOneFile = true;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['parent_id', 'order', 'promoted'], 'integer'],
            [['custom'], 'string'],
            [['name', 'slug', 'type'], 'string', 'max' => 245]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'slug' => Yii::t('app', 'Slug'),
            'type' => Yii::t('app', 'Type'),
            'parent_id' => Yii::t('app', 'Parent'),
            'order' => Yii::t('app', 'Order'),
            'promoted' => Yii::t('app', 'Promoted'),
            'custom' => Yii::t('app', 'Custom'),
            'uploadedFiles' => Yii::t('app', 'Image'),
            'language' => Yii::t('app', 'Language'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(\app\models\mgcms\db\Category::className(), ['id' => 'parent_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(\app\models\mgcms\db\Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(\app\models\mgcms\db\Article::className(), ['category_id' => 'id'])->orderBy('order asc');
    }
    
/**
     * @inheritdoc
     * @return array mixed
     */ 
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\CategoryQuery(get_called_class());
    }
}
