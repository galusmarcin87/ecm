<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Article;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

$category = \app\models\mgcms\db\Category::find()->where(['name' => 'aktualności ' . Yii::$app->language])->one();
if (!$category) {
    return false;
}
$dataProvider = new ActiveDataProvider([
    'pagination' => ['pageSize' => '3'],
    'query' => Article::find()->where(['category_id' => $category->id])
        ->andWhere(['status' => Article::STATUS_ACTIVE])
        ->orderBy('order ASC , created_on DESC'),
]);

$showAllButton = isset($showAllButton) ? $showAllButton : true;
?>


<section
        class="Section Projects Projects--list animatedParent Projects--lightBg"
>
    <div class="container fadeIn animated">
        <div class="Projects__header__wrapper">
            <h1 class="text-center"><?= Yii::t('db', 'News'); ?></h1>
        </div>
    </div>
    <div class="container fadeIn animated">
        <?=
        ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => [
                'class' => 'animatedParent'
            ],
            'options' => [
                'class' => 'Projects__sortable animatedParent',
            ],
            'layout' => '{items}',
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('/article/_index', ['model' => $model, 'key' => $key, 'index' => $index, 'widget' => $widget, 'view' => $this]);
            },
        ])

        ?>
    </div>
    <div class="text-center">
        <a href="<?= $category->linkUrl ?>" class="btn btn-success btn--medium"> <?= Yii::t('db', 'See all'); ?></a>
    </div>
</section>


