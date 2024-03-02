<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\bootstrap\ActiveForm;
use yii\web\View;


$socialFacebook = MgHelpers::getSettingTypeText('facebook', false, false);
$socialTwitter = MgHelpers::getSettingTypeText('twitter', false, false);
$socialInstagram = MgHelpers::getSettingTypeText('instagram', false, false);
$socialTiktok = MgHelpers::getSettingTypeText('tiktok', false, false);
$socialYoutube = MgHelpers::getSettingTypeText('youtube', false, false);
$socialReddit = MgHelpers::getSettingTypeText('reddit', false, false);
$socialDiscord = MgHelpers::getSettingTypeText('discord', false, false);
$socialTelegram = MgHelpers::getSettingTypeText('telegram', false, false); 
?>
<div class="container">
    <div class="side-buttons-wrapper">
        <div class="side-buttons">
            <ul class="nav nav-social">
                <? if ($socialReddit): ?>
                    <li class="nav-item">
                        <a href="<?= $socialReddit ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#reddit"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>

                <? if ($socialInstagram): ?>
                    <li class="nav-item">
                        <a href="<?= $socialInstagram ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#instagram"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>

                <? if ($socialYoutube): ?>
                    <li class="nav-item">
                        <a href="<?= $socialYoutube ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#youtube"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>

                <? if ($socialFacebook): ?>
                    <li class="nav-item">
                        <a href="<?= $socialFacebook ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#facebook"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>
				
				<? if ($socialTwitter): ?>
                    <li class="nav-item">
                        <a href="<?= $socialTwitter ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#twitter"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>
				
				<? if ($socialTiktok): ?>
                    <li class="nav-item">
                        <a href="<?= $socialTiktok ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#tiktok"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>
				
				<? if ($socialDiscord): ?>
                    <li class="nav-item">
                        <a href="<?= $socialDiscord ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#discord"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>
				
				<? if ($socialTelegram): ?>
                    <li class="nav-item">
                        <a href="<?= $socialTelegram ?>" class="nav-link">
                            <svg class="icon">
                                <use xlink:href="#telegram"/>
                            </svg>
                        </a>
                    </li>
                <? endif ?>

            </ul>
        </div>
    </div>
</div>
