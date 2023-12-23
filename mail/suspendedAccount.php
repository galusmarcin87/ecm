<?
use app\components\mgcms\MgHelpers;

?>

<h1><?= Yii::t('db', 'Noble Platform - Your account has been suspended'); ?></h1>

<div>
  <?= MgHelpers::getSettingTranslated('mail_user_suspended_text', 'Your account has been suspended') ?>
</div>