<?
/* @var $model app\models\ForgotPasswordForm */
use app\components\mgcms\MgHelpers;

?>

<?= Yii::t('db', 'So change password click link below');?>
<?=
\yii\helpers\Html::a(Yii::t('db', 'Reset'), \yii\helpers\Url::to(['site/forgot-password-change', 'hash' => MgHelpers::encrypt($model->email)], true))?>