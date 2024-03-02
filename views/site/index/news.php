<?
/* @var $this yii\web\View */

// sekcja aktualnosci na home

use app\components\mgcms\MgHelpers;
use yii\data\ActiveDataProvider;
use yii\web\View;
use app\models\mgcms\db\Article;
use yii\widgets\ListView;

$category = \app\models\mgcms\db\Category::find()->where(['name' => 'aktualności ' . Yii::$app->language])->one();
if (!$category) {
    return false;
}

$query = Article::find()->where(['status' => Article::STATUS_ACTIVE, 'category_id' => $category->id])->orderBy(['id' => SORT_DESC]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 3,
    ],
    'sort' => [
        'attributes' => [
            'order' => SORT_DESC,
        ]
    ],
]);

?>

<div class="media-section section-dark-left py-5">
    <div class="section-content">
        <div class="section-title text-center"><?= Yii::t('db', 'News') ?></div>
        <div class="section-background">
            <div class="container">
                <?=
                ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemOptions' => [
                        'class' => 'col-lg-4'
                    ],
                    'options' => [
                        'class' => 'row',
                    ],
                    'layout' => '{items}',
                    'itemView' => function ($model, $key, $index, $widget) {
                        return $this->render('/article/_index', ['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this]);
                    },
                ])

                ?>

                <div class="text-center my-5">
                    <a href="<?= $category->linkUrl ?>"
                       class="readmore btn btn-primary"><?= Yii::t('db', 'See all') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
