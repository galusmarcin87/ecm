<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
$model->language = Yii::$app->language;
?>

<a class="card card-light mb-3" href="<?= $model->getLinkUrl() ?>">
    <div class="card-main-image img-corner-right-top">
        <? if ($model->file && $model->file->isImage()): ?>
            <img src="<?= $model->file->getImageSrc(450, 271); ?>" class="card-img-top" alt="<?= $model ?>"/>
        <? endif; ?>
        <div class="card-main-image-overlay">
            <span class="btn"><?= Yii::t('db', 'See details') ?></span>
        </div>
    </div>
    <div class="card-body">
        <h5 class="card-title card-title--portfolio">
            <?= $model->name ?>
        </h5>
        <div class="row">
            <div class="col-md-6">
                <div class="portfolio-icons">
                    <div class="portfolio-icons-icon">
                        <svg class="icon">
                            <use xlink:href="#calendar"/>
                        </svg>
                    </div>
                    <div class="portfolio-icons-text">
                        <?= $model->investition_time ?> <?= Yii::t('db', 'years') ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="portfolio-icons">
                    <div class="portfolio-icons-icon">
                        <svg class="icon">
                            <use xlink:href="#procent"/>
                        </svg>
                    </div>
                    <div class="portfolio-icons-text">
                        <?= $model->percentage ?>% <?= Yii::t('db', 'of return') ?>
                    </div>
                </div>
            </div>
        </div>
        <?= $model->lead ?>
        <?= $this->render('_counterMoney', ['model' => $model]) ?>
        <?= $this->render('_counterTimer', ['model' => $model]) ?>

    </div>
</a>
