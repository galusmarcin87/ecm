<?php
/* @var $model app\models\mgcms\db\Project */

/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use yii\web\View;
use yii\helpers\Url;

$this->title = $model->name;
$model->language = Yii::$app->language;
if (!$model->money_full) {
    return false;
}

$index = 0;
?>

<section
        class="Section Section--big-padding-top Tokenomania"
        style="padding-bottom: 0"
>
    <div class="container">
        <h2 class="O-projekcie__header"><?= Yii::t('db', 'Tokenomia'); ?></h2>
        <div class="row">
            <div class="col-lg-4">
                <h6 class="O-projekcie__text text-left">
                    <?= $model->lead ?>
                </h6>
                <div style="margin-top: 30px">
                    <a class="btn btn-primary btn-full-width"
                       href="<?= Url::to(['project/buy', 'id' => $model->id]) ?>"><?= Yii::t('db', 'INVEST'); ?></a>
                    <a class="btn btn-black btn-full-width"
                       href="<?= $model->whitepaper ?>"><?= Yii::t('db', 'WHITEPAPER'); ?></a>
                    <a class="btn btn-black btn-full-width" href="#">ONEPAGER</a>
                </div>
            </div>
            <div class="col-lg-8">
                <section class="Counter Counter--small">
                    <div class="container">


                        <div class="Slider-counter">
                            <div
                                    data-date="<?= $model->date_crowdsale_end ?>"
                                    class="Count-down-timer Count-down-timer--small"
                            >
                                <div class="Slider-counter__heading"><?= Yii::t('db', 'Left'); ?></div>
                                <div class="Count-down-timer__day"><span></span> <?= Yii::t('db', 'days'); ?></div>
                                <div class="Count-down-timer__hour">
                                    <span></span> <?= Yii::t('db', 'hours'); ?>
                                </div>
                                <div class="Count-down-timer__minute">
                                    <span></span> <?= Yii::t('db', 'minutes'); ?>
                                </div>
                                <div class="Count-down-timer__second">
                                    <span></span> <?= Yii::t('db', 'seconds'); ?>
                                </div>
                            </div>
                            <div class="Invest-counter">
                                <div class="Invest-counter__header">
                                    <div class="Invest-counter__source">
                        <span class="Invest-counter__source__value"
                        ><?= $model->money ?> PLN</span
                        >
                                        (<span
                                                data-to="<?= round(($model->money / $model->money_full) * 100, 3) ?>"
                                                class="Invest-counter__source__percent"
                                        >0</span
                                        >%)
                                    </div>
                                    <div class="Invest-counter__target">
                                        cel: <?= \Yii::$app->formatter->asNumberSeparatedWithSpace($model->money_full) ?> PLN
                                    </div>
                                </div>
                                <div class="Invest-counter__value-line-wrapper">
                                    <div
                                            data-to="<?= $model->money ?>"
                                            data-slide-to="<?= round(($model->money / $model->money_full) * 100, 3) ?>"
                                            class="Invest-counter__value-line"
                                            style="width: 0%"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <section class="Section Project">
        <div class="container">
            <div class="Project__info">
                <div>
                    <div class="Carousel Single-image-slider">
                        <div class="owl-carousel owl-theme animatedParent">
                            <? foreach ($model->files as $file): ?>
                                <? if ($file->isImage()): $index++; ?>
                                    <a class="Image-slider__card item" href="<?= $file->getImageSrc(1360, 768) ?>">
                                        <img
                                                class="Image-slider__image fadeIn animated"
                                                src="<?= $file->getImageSrc(822, 460) ?>"
                                                alt=""
                                        />
                                    </a>
                                <? endif; ?>
                            <? endforeach; ?>
                        </div>
                        <div
                                class="Custom-nav Custom-nav--color-black Single-image-slider__nav"
                        ></div>
                    </div>
                    <?= $model->text ?>
                </div>
                <div class="Project__info__content">
                    <?= $this->render('view/table', ['model' => $model]) ?>

                    <?= $this->render('view/tokenTable', ['model' => $model]) ?>

                    <?= $this->render('view/bonuses', ['model' => $model]) ?>


                </div>
            </div>
        </div>
    </section>
</section>
<section class="Section Analize animatedParent">
    <div class="container fadeIn animated">
        <?= $model->text2 ?>
    </div>
</section>


