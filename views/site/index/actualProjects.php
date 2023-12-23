<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\data\ActiveDataProvider;
use yii\web\View;
use app\models\mgcms\db\Project;
use yii\widgets\ListView;

$query = Project::find()->where(['status' => Project::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC]);

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

<div class="tokens-section section-dark-left py-5">
	<div class="section-content">
		<div class="section-title text-center"><?= Yii::t('db', 'Current campaigns') ?></div>
		<div class="section-background">
        <div class="container">
            <div class="row">
				<div class="col-lg-4">
					<div class="card card-dark mb-3">
						<div class="card-main-image img-corner-right-top">
							<div class="card-main-image-overlay">
								<span class="btn"><?= Yii::t('db', 'Details') ?></span>
							</div>
							<div class="swiper current-campaigns">
								<?=
	ListView::widget([
		'dataProvider' => $dataProvider,
		'itemOptions' => [
			'class' => 'swiper-slide'
		],
		'options' => [
			'class' => 'swiper-wrapper',
		],
		'layout' => '{items}',
		'itemView' => function ($model, $key, $index, $widget) {
			return $this->render('/project/_tileItem', ['model' => $model, 'key' => $key, 'index' => $index, 'view' => $this]);
		},
	])
								?>
								<div class="swiper-pagination"></div>	
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
		</div>
		</div>
</div>