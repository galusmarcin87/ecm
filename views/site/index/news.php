<?
/* @var $this yii\web\View */
// sekcja aktualnosci na home

use app\components\mgcms\MgHelpers;
use yii\data\ActiveDataProvider;
use yii\web\View;
use app\models\mgcms\db\Article;
use yii\widgets\ListView;

$query = Article::find()->where(['status' => Article::STATUS_ACTIVE,'type'=>Article::TYPE_NEWS])->orderBy(['id' => SORT_DESC]);

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

<div class="news-section section-dark-right py-5">
	<div class="section-content">
		<div class="section-title text-center"><?= Yii::t('db', 'News') ?></div>
		<div class="section-background">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<a class="card card-dark mb-3" href="/posts-item.html">
							<div class="card-main-image img-corner-left-top">
								<img src="/images/tokens-img.jpg" class="card-img-top" alt="Token">
								<div class="card-main-image-overlay">
                                    <span class="btn">Poznaj szczegóły</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-date">
                                    21.05.2023
                                </div>
								<h5 class="card-title--news">
                                            Energrtyka przyszłości EMC
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                </p>
                                <span class="card-readmore">Czytaj więcej</span>
							</div>
						</a>
                    </div>
            </div>
				<div class="text-center my-5">
					<a href="<?= \yii\helpers\Url::to(['/article']) ?>" class="readmore btn btn-primary"><?= Yii::t('db', 'See all') ?></a>
				</div>
        </div>
    </div>
	</div>
</div>
