<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
$model->language = Yii::$app->language;
?>

<div class="portfolio-countdown">
    <p class="text-uppercase">
        <strong><?= Yii::t('db', 'Time left') ?>:</strong>
    </p>
    <div data-date="<?= $model->date_crowdsale_end ?>" data-time="0:00" class="countdown">
        <div class="day"><span class="num"></span><span class="word"> <?= Yii::t('db', 'days') ?></span></div>
        <div class="hour"><span class="num"></span><span class="word"> <?= Yii::t('db', 'hours') ?></span></div>
        <div class="min"><span class="num"></span><span class="word"> <?= Yii::t('db', 'minutes') ?></span></div>
        <div class="sec"><span class="num"></span><span class="word"> <?= Yii::t('db', 'seconds') ?></span></div>
    </div>
</div>




