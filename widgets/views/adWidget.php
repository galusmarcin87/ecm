<?

/* @var $ads \app\models\mgcms\db\Ad[] */
if(count($ads)== 0){
    return false;
}
?>

<div id="adWrapper" class="container">
    <span class="close" onclick="$('#adWrapper').hide()"><?= Yii::t('db', 'CLOSE') ?></span>
    <div id="AD-SLIDER" class="owl-carousel owl-theme">
        <? foreach ($ads as $ad): ?>
            <div class="item">
                <div class="item Partners__item">
                    <a class="Partners__item__link" href="<?= $ad->link ?>">
                        <img src="<?= $ad->file->getImageSrc(0, 800 ) ?>"/>
                    </a>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>

