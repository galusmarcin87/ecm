<?
/* @var $model app\models\mgcms\db\Product */

/* @var $this View */

use yii\web\View;
use \app\models\mgcms\db\Category;
use yii\widgets\ListView;
use yii\helpers\Url;
use app\components\mgcms\MgHelpers;

$companyCategories = Category::find()->where(['type' => Category::TYPE_COMPANY_TYPE])->all();
$productCategories = Category::find()->where(['type' => Category::TYPE_PRODUCT_TYPE])->all();
$industries = MgHelpers::getSettingOptionArrayTranslated('industries array');

$request = $this->context->request;

?>

<div class="menu-vertical menu-vertical--closed">
    <div class="label"><?= Yii::t('db', 'Filter') ?></div>
    <div class="menu-vertical__toggle">
        <i class="fa fa-times" aria-hidden="true"></i>
        <i class="fa fa-bars" aria-hidden="true"></i>
    </div>

    <? if ($request->getPathInfo() == 'company/index' && !$request->getQueryParam('is_for_sale')): ?>
        <div class="menu-vertical__category">
            <div class="menu-vertical__item <?= $request->getPathInfo() == 'company/index' && !$request->getQueryParam('is_for_sale') ? 'menu-vertical__item--active' : '' ?>">
                <?= Yii::t('db', 'Companies') ?>
            </div>
            <? foreach ($companyCategories as $category): ?>
                <a
                        href="<?= \yii\helpers\Url::to(['company/index', 'category_id' => $category->id]) ?>"
                        class="menu-vertical__item <? if ($request->getQueryParam('category_id') == $category->id): ?>menu-vertical__item--active<? endif; ?>"
                >
                    <?= Yii::t('db', $category->name) ?>
                </a>
            <? endforeach; ?>
        </div>
    <? else: ?>
        <a href="<?= Url::to(['company/index']) ?>" class="menu-vertical__category">
            <div class="menu-vertical__item <?= $request->getPathInfo() == 'company/index' && !$request->getQueryParam('is_for_sale') ? 'menu-vertical__item--active' : '' ?>"><?= Yii::t('db', 'Companies') ?></div>
        </a>
    <? endif ?>

    <? if ($request->getPathInfo() == 'product/index'): ?>
        <div class="menu-vertical__category">
            <div class="menu-vertical__item <?= $request->getPathInfo() == 'product/index' ? 'menu-vertical__item--active' : '' ?>">
                <?= Yii::t('db', 'Products') ?>
            </div>
            <? foreach ($productCategories as $category): ?>
                <a
                        href="<?= \yii\helpers\Url::to(['product/index', 'category_id' => $category->id]) ?>"
                        class="menu-vertical__item <? if ($request->getQueryParam('category_id') == $category->id): ?>menu-vertical__item--active<? endif; ?>"
                >
                    <?= Yii::t('db', $category->name) ?>
                </a>
            <? endforeach; ?>
        </div>
    <? else: ?>
        <a href="<?= Url::to(['product/index']) ?>" class="menu-vertical__category">
            <div class="menu-vertical__item <?= $request->getPathInfo() == 'product/index' ? 'menu-vertical__item--active' : '' ?>"><?= Yii::t('db', 'Products') ?></div>
        </a>
    <? endif ?>


    <a href="<?= Url::to(['company/index', 'is_for_sale' => 1]) ?>" class="menu-vertical__category">
        <div class="menu-vertical__item <?= $request->getPathInfo() == 'company/index' && $request->getQueryParam('is_for_sale') ? 'menu-vertical__item--active' : '' ?>"><?= Yii::t('db', 'Companies for sale') ?></div>
    </a>


    <? if ($request->getPathInfo() == 'service/index'): ?>
        <div class="menu-vertical__category">
            <div class="menu-vertical__item <?= $request->getPathInfo() == 'service/index' ? 'menu-vertical__item--active' : '' ?>">
                <?= Yii::t('db', 'Services') ?>
            </div>
            <? foreach ($companyCategories as $category): ?>
                <a
                        href="<?= \yii\helpers\Url::to(['service/index', 'category_id' => $category->id]) ?>"
                        class="menu-vertical__item <? if ($request->getQueryParam('category_id') == $category->id): ?>menu-vertical__item--active<? endif; ?>"
                >
                    <?= Yii::t('db', $category->name) ?>
                </a>
            <? endforeach; ?>
        </div>
    <? else: ?>
        <a href="<?= Url::to(['service/index']) ?>" class="menu-vertical__category">
            <div class="menu-vertical__item <?= $request->getPathInfo() == 'service/index' ? 'menu-vertical__item--active' : '' ?>"><?= Yii::t('db', 'Services') ?></div>
        </a>
    <? endif ?>

    <? if ($request->getPathInfo() == 'job/index'): ?>
        <div class="menu-vertical__category">
            <div class="menu-vertical__item <?= $request->getPathInfo() == 'job/index' ? 'menu-vertical__item--active' : '' ?>">
                <?= Yii::t('db', 'Jobs offers') ?>
            </div>
            <? foreach ($industries as $industry => $industryTranslated): ?>
                <a
                        href="<?= \yii\helpers\Url::to(['job/index', 'industry' => $industry]) ?>"
                        class="menu-vertical__item <? if ($request->getQueryParam('industry') == $industry): ?>menu-vertical__item--active<? endif; ?>"
                >
                    <?= $industryTranslated ?>
                </a>
            <? endforeach; ?>
        </div>
    <? else: ?>
        <a href="<?= Url::to(['job/index']) ?>" class="menu-vertical__category">
            <div class="menu-vertical__item <?= $request->getPathInfo() == 'job/index' ? 'menu-vertical__item--active' : '' ?>"><?= Yii::t('db', 'Jobs offers') ?></div>
        </a>
    <? endif ?>


</div>
