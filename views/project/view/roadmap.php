<?
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */

?>

<div class="roadmap-slider">


    <h2 class="text-uppercase fw-bold font-oswald"><?= Yii::t('db', 'Roadmap') ?></h2>

    <div class="swiper project-roadmap-carousel">
        <div class="swiper-wrapper">

            <?foreach ($model->bonuses as $bonus):?>
                <div class="swiper-slide col-md-5">
                    <div class="roadmap-item">
                        <h3><?= $bonus->from?></h3>
                        <p><?= $bonus->value?></p>
                    </div>
                </div>
            <?endforeach;?>

        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
