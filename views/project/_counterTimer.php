<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
$model->language = Yii::$app->language;
$cssClass = isset($cssClass) ? $cssClass : 'portfolio-countdown';
if($model->date_crowdsale_end){
    return false;
}
?>

<div class="<?= $cssClass ?>">
    <p class="text-uppercase">
        <strong><?= Yii::t('db', 'Time left') ?>:</strong>
    </p>
    <div class="countdown" data-date="<?= Date('d-m-Y', strtotime($model->date_crowdsale_end)) ?>"
         data-time="<?= Date('H:i', strtotime($model->date_crowdsale_end)) ?>">
        <div class="day"><span class="num"></span><span class="word"> <?= Yii::t('db', 'days') ?></span></div>
        <div class="hour"><span class="num"></span><span class="word"> <?= Yii::t('db', 'hours') ?></span></div>
        <div class="min"><span class="num"></span><span class="word"> <?= Yii::t('db', 'minutes') ?></span></div>
        <div class="sec"><span class="num"></span><span class="word"> <?= Yii::t('db', 'seconds') ?></span></div>
    </div>
</div>




