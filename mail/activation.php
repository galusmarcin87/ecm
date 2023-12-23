<?
use app\components\mgcms\MgHelpers;
?>

<?= Yii::t('db', 'Your activation link:');
?><a href="<?=yii\helpers\Url::to(['/site/activate','hash' => app\components\mgcms\MgHelpers::encrypt($model->id)], true)?>">
<?= Yii::t('db', 'Click here'); ?></a>
