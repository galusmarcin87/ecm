<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\bootstrap\ActiveForm;
use yii\web\View;

$slider = \app\models\mgcms\db\Slider::find()->where(['name' => 'main', 'language' => Yii::$app->language])->one();
if (!$slider) {
    return false;
}

?>

<?= $this->render('/common/sideSocialButtons')?>

<div class="slider-section">
    <div class="splide">
        <div class="container">
            <div class="position-relative">
                <div class="splide__track">
                    <ul class="splide__list">
                        <? foreach ($slider->slides as $index => $slide): ?>
                            <li class="splide__slide">
                                <div class="slide-content">
                                    <div class="slide-content-inner">
                                        <div class="row gx-0 px-1 align-items-center">
                                            <div class="col-lg-5 py-4">
                                                <h2 class="font-oswald">
                                                    <?= $slide->header ?>
                                                </h2>
                                                <p>
                                                    <?= $slide->body ?>
                                                </p>
                                                <a href="<?= $slide->link ?>"
                                                   class="btn btn-primary"><?= Yii::t('db', 'See details') ?></a>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <? if ($slide->file && $slide->file->isImage()): ?>
                                                    <img src="<?= $slide->file->getImageSrc() ?>"
                                                         class="img-fluid slider-img"
                                                         alt="">
                                                <? endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <? endforeach; ?>


                    </ul>
                </div>
                <div class="slider-nav">
                    <div class="splide__arrows"></div>
                    <ul class="splide__pagination"></ul>

                </div>
            </div>
        </div>

    </div>
</div>

