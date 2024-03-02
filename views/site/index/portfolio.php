<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\data\ActiveDataProvider;
use yii\web\View;
use app\models\mgcms\db\Project;
use yii\widgets\ListView;

$query = Project::find()->where(['status' => Project::STATUS_ACTIVE, 'type' => Project::TYPE_SDT])->orderBy(['id' => SORT_DESC]);

$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 9,
    ],
    'sort' => [
        'attributes' => [
            'order' => SORT_DESC,
        ]
    ],
]);

?>

<div class="portfolio-section py-5">
    <div class="section-content">
        <div class="section-title text-center"><?= Yii::t('db', 'SDT energy cluster portfolio') ?></div>
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
                        return $this->render('/project/_tileItem', ['model' => $model, 'key' => $key, 'index' => $index, 'view' => $this]);
                    },
                ])
                ?>

                <div class="text-center my-5">
                    <a href="<?= \yii\helpers\Url::to(['/project/index', 'type' => Project::TYPE_SDT]) ?>"
                       class="btn btn-wide btn-primary"><?= Yii::t('db', 'See all') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
