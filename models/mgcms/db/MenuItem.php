<?php

namespace app\models\mgcms\db;

use Yii;

/**
 * This is the base model class for table "menu_item".
 *
 * @property integer $id
 * @property string $url
 * @property string $label
 * @property integer $order
 * @property integer $menu_id
 * @property integer $parent_id
 * @property integer $article_id
 * @property integer $category_id
 *
 * @property \app\models\mgcms\db\Article $article
 * @property \app\models\mgcms\db\Category $category
 * @property \app\models\mgcms\db\Menu $menu
 * @property \app\models\mgcms\db\MenuItem $parent
 * @property \app\models\mgcms\db\MenuItem[] $children
 */
class MenuItem extends \app\models\mgcms\db\AbstractRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'menu_id', 'parent_id', 'article_id', 'category_id'], 'integer'],
            [['menu_id'], 'required'],
            [['url', 'label'], 'string', 'max' => 245]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
            'label' => Yii::t('app', 'Label'),
            'order' => Yii::t('app', 'Order'),
            'menu_id' => Yii::t('app', 'Menu ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'article_id' => Yii::t('app', 'Article ID'),
            'category_id' => Yii::t('app', 'Category ID'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(\app\models\mgcms\db\Article::className(), ['id' => 'article_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(\app\models\mgcms\db\Category::className(), ['id' => 'category_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(\app\models\mgcms\db\Menu::className(), ['id' => 'menu_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(\app\models\mgcms\db\MenuItem::className(), ['id' => 'parent_id']);
    }
        
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(\app\models\mgcms\db\MenuItem::className(), ['parent_id' => 'id'])->orderBy('`order` ASC');
    }
    

    /**
     * @inheritdoc
     * @return \app\models\mgcms\db\MenuItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\mgcms\db\MenuItemQuery(get_called_class());
    }
}
