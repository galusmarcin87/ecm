<?php

namespace app\models\mgcms\db;

use \app\models\mgcms\db\base\Category as BaseCategory;
use http\Url;
use yii\behaviors\SluggableBehavior;

/**
 * This is the base model class for table "category".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $type
 * @property integer $parent_id
 * @property integer $order
 * @property integer $promoted
 * @property string $custom
 * @property string $language
 * @property string $url
 * @property string $link
 * @property string $linkUrl
 * @property string $nameTranslated
 *
 * @property \app\models\mgcms\db\Category $parent
 * @property \app\models\mgcms\db\Category[] $categories
 * @property \app\models\mgcms\db\Article[] $articles
 */
class Category extends BaseCategory
{

    const TYPE_ARTICLE = 'article';
    const TYPE_COMPANY_TYPE = 'company_type';
    const TYPE_PRODUCT_TYPE = 'product_type';
    const TYPES = [
        Category::TYPE_ARTICLE,
        Category::TYPE_COMPANY_TYPE,
        Category::TYPE_PRODUCT_TYPE,
    ];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(), [
            [['name', 'slug'], 'required'],
            [['parent_id', 'order', 'promoted'], 'integer'],
            [['custom', 'language'], 'string'],
            [['name', 'slug', 'type'], 'string', 'max' => 245]
        ]);
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'slug',
            ],
        ];
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getUrl()
    {
        return \app\components\mgcms\MgHelpers::createUrl(['/article/category', 'categorySlug' => $this->getCategorySlugUrl()]);
    }

    public function getCategorySlugUrl()
    {
        $str = '/';
        if ($this->parent) {
            $str .= $this->parent->getUrl() . '/';
        }

        return $str . $this->slug;
    }

    public function getLink()
    {
        return \kartik\helpers\Html::a((string)$this, $this->getLinkUrl());
    }

    public function getLinkUrl()
    {
        return \yii\helpers\Url::to(['/article/category', 'categorySlug' => $this->getCategorySlugUrl()]);
    }

    /**
     *
     * @param string $$fullCategorySlug
     * @return Category
     */
    public static function findByUrl($fullCategorySlug)
    {
        $categorySlugs = explode('/', $fullCategorySlug);
        $categorySlug = $categorySlugs[sizeof($categorySlugs) - 1];
        $categories = Category::findAll(['slug' => $categorySlug]);
        if (sizeof($categories) === 1) {
            return $categories[0];
        } else {
            unset($categorySlugs[sizeof($categorySlugs) - 1]);
            foreach ($categories as $category) {
                $parentCategory = self::findByUrl(implode('/', $categorySlugs));
                if ($parentCategory->id === $category->id) {
                    return $category;
                }
            }
            return $categories[0];
        }
    }


    public function getCategoryTree()
    {
        $parent = $this->parent;
        $categories = [$this];

        while ($parent) {
            $categories[] = $parent;
            $parent = $parent->parent;
        }

        return $categories;

    }

    public function getNameTranslated()
    {
        return \Yii::t('db', $this->name);
    }
}
