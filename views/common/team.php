<?

use app\components\mgcms\MgHelpers;
use \app\models\mgcms\db\User;

$teamUsers = User::find()->where(['status' => User::STATUS_INACTIVE, 'role' => 'team'])->all();
if(sizeof($teamUsers) == 0){
    return false;
}

?>

<section class="Section Team animatedParent">
    <div class="container fadeIn animated">
        <h1 class="text-center">Nasz zespół</h1>
        <div class="Team__carousel owl-carousel">
            <? foreach ($teamUsers as $teamUser): ?>
                <div class="item Team__item">
                    <? if ($teamUser->file && $teamUser->file->isImage()): ?>
                        <img class="Team__item__photo" src="<?= $teamUser->file->getImageSrc(160, 160) ?>"/>
                    <? endif ?>
                    <div class="Team__item__name">
                        <?= $teamUser->first_name ?> <?= $teamUser->last_name ?><br/>
                        <?= $teamUser->getModelAttribute('position') ?>
                    </div>
                    <div>
                        <a href="mailto:<?= $teamUser->username ?>"><?= $teamUser->username ?></a>
                    </div>
                    <div>
                        <a href="tel:<?= str_replace(' ', '', $teamUser->phone) ?>"><?= $teamUser->phone ?></a>
                    </div>
                    <div class="Social-icons Team__item__social-icons">
                        <? if ($teamUser->getModelAttribute('facebook')): ?>
                            <a class="Social-icons__icon" href="<?= $teamUser->getModelAttribute('facebook') ?>">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                        <? endif ?>

                        <? if ($teamUser->getModelAttribute('twitter')): ?>
                            <a class="Social-icons__icon" href="<?= $teamUser->getModelAttribute('twitter') ?>">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                        <? endif ?>
                        <? if ($teamUser->getModelAttribute('linkedin')): ?>
                            <a class="Social-icons__icon" href="<?= $teamUser->getModelAttribute('linkedin') ?>">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                        <? endif ?>
                        <? if ($teamUser->getModelAttribute('instagram')): ?>
                            <a class="Social-icons__icon" href="<?= $teamUser->getModelAttribute('instagram') ?>">
                                <img
                                        class="Social-icons__icon__img"
                                        src="/svg/instagram.svg"
                                        alt=""
                                />
                            </a>
                        <? endif ?>
                    </div>
                </div>
            <? endforeach; ?>

        </div>
    </div>
</section>
