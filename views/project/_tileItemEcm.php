<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
if(!$model){
    return false;
}
if($model->useLanguage){
    $model->language = Yii::$app->language;
}
?>
<a class="card card-dark mb-3" href="<?= $model->getLinkUrl() ?>">
    <div class="card-main-image img-corner-right-top">
        <? if ($model->file && $model->file->isImage()): ?>
            <img src="<?= $model->file->getImageSrc(450, 271); ?>" class="card-img-top" alt="<?= $model ?>"/>
        <? endif; ?>
        <div class="card-main-image-overlay">
            <span class="btn"><?= Yii::t('db', 'See details') ?></span>
        </div>
    </div>
    <div class="card-body">
        <h5 class="card-title card-title-has-icon">
            <div class="card-title-icon">
                <img src="/images/tokens/<?= $model->type ?>.png" alt="">
            </div>
            <div class="card-title-text">
                <?= $model ?>
            </div>
        </h5>
        <div class="">
            <?= $model->lead ?>
        </div>

    </div>
</a>
