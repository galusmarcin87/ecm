<?
/* @var $this yii\web\View */

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\bootstrap\ActiveForm;
use yii\web\View;



$socialReddit = MgHelpers::getSettingTypeText('reddit', false, false);
$socialInstagram = MgHelpers::getSettingTypeText('instagram', false, false);
$socialYoutube = MgHelpers::getSettingTypeText('youtube', false, false);
$socialFacebook = MgHelpers::getSettingTypeText('facebook', false, false);
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

            </ul>
        </div>
    </div>
</div>
