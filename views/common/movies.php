<?

use app\models\mgcms\db\Project;
use app\components\mgcms\MgHelpers;

if (MgHelpers::getSetting('home - filmy youtube') == '') {
    return false;
}

?>

<section class="Section Section--white Video">
    <div class="container">
        <div class="text-center">
            <b><?= Yii::t('db', 'OUR'); ?></b>
        </div>
        <h1 class="text-center"><?= Yii::t('db', 'Media'); ?></h1>
        <div class="Carousel">
            <div class="owl-carousel owl-theme animatedParent">
                <? foreach (MgHelpers::getSettingsArray('home - filmy youtube z obrazkami', 'https://www.youtube.com/watch?v=ScMzIvxBSi4|/images/project_01.jpg,https://www.youtube.com/watch?v=ScMzIvxBSi4|/images/project_02.jpg') as $ytUrl): ?>
                    <?
                    $ytExploded = explode('|', $ytUrl);
                    if (sizeof($ytExploded) != 2) continue;
                    ?>
                    <div
                            class="Video__card fadeIn animated item"
                            data-src="<?=$ytExploded[0]?>"
                    >
                        <img
                                class="Video__card__placeholder"
                                src="<?=$ytExploded[1]?>"
                                alt=""
                        />
                        <div class="Custom-nav Video__nav"></div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
        <div class="text-center">
            <a href="<?=MgHelpers::getSetting('home - video - channe link')?>" class="btn btn-success" target="_blank"> <?= Yii::t('db', 'Visit our channel'); ?> </a>
        </div>
    </div>
</section>

