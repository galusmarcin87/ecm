<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
$model->language = Yii::$app->language;
?>


<a class="card card-campaign mb-3" href="<?= $model->getLinkUrl()?>">
    <div class="card-main-image img-rounded-right-top">
        <? if ($model->file && $model->file->isImage()): ?>
            <img src="<?= $model->file->getImageSrc(1200, 800); ?>" class="card-img-top" alt="<?= $model ?>"/>
        <? endif; ?>
							<div class="card-main-image-overlay">
								<span class="btn"><?= Yii::t('db', 'Details') ?></span>
							</div>
        <div class="card-main-image-like">
            <svg class="icon">
                <use xlink:href="#like-outline"/>
            </svg>
        </div>
    </div>
	
	<div class="card-body">
		<h5 class="card-title card-title-has-icon">
			<div class="card-title-icon">
				<img src="/images/tokens/ecm.png" alt="">
			</div> 
			
			<div class="card-title-text">
				<?= $model ?>
			</div>
		</h5>
			
			<div>
				<?= $model->lead ?>
			</div>
    </div>
</a>
