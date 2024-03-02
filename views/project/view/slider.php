<?

use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */

?>



<? if ($model->files && sizeof($model->files) > 0): ?>
    <div class="project-slider">


        <div class="splide project-main-slider" id="project-main-carousel">
            <div class="splide__track">
                <ul class="splide__list">
                    <? foreach ($model->files as $file): ?>
                        <? if ($file->isImage()): ?>
                            <li class="splide__slide">
                                <a href="<?= $file->getImageSrc() ?>" class="slide-link mfp">
                                    <img src="<?= $file->getImageSrc(1200, 800) ?>" class="img-fluid" alt="">
                                </a>
                            </li>
                        <? endif; ?>
                    <? endforeach; ?>

                </ul>
            </div>
            <div class="slider-nav">
                <div class="splide__arrows"></div>
                <ul class="splide__pagination"></ul>

            </div>
        </div>

        <div class="splide project-thumbnail-slider" id="project-thumbnail-carousel">
            <div class="splide__track">
                <ul class="splide__list">
                    <? foreach ($model->files as $file): ?>
                        <? if ($file->isImage()): ?>
                            <li class="splide__slide">
                                <img src="<?= $file->getImageSrc(173, 120) ?>" class="img-fluid" alt="">
                            </li>
                        <? endif; ?>
                    <? endforeach; ?>

                </ul>
            </div>
            <div class="slider-nav">
                <div class="splide__arrows"></div>
                <ul class="splide__pagination"></ul>

            </div>
        </div>
    </div>
<? endif; ?>
