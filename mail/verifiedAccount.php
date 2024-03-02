<?
use app\components\mgcms\MgHelpers;

?>

<h1><?= Yii::t('db', 'Noble Platform - Your account has been verified'); ?></h1>

<div>
  <?= MgHelpers::getSettingTranslated('mail_user_verified_text', 'Your account has been verified') ?>
</div>