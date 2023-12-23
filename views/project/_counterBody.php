<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
$model->language = Yii::$app->language;
?>

<div class="counter-body">
    <div class="counter-body__heading">
        <?= Yii::t('db', 'Time left to the end of collection') ?>
    </div>
    <div data-date="<?= $model->date_crowdsale_end ?>" class="count-down-timer">
        <div class="count-down-timer__day"><span></span> <?= Yii::t('db', 'days') ?></div>
        <div class="count-down-timer__hour"><span></span> <?= Yii::t('db', 'hours') ?></div>
        <div class="count-down-timer__minute"><span></span> <?= Yii::t('db', 'minutes') ?></div>
        <div class="count-down-timer__second"><span></span> <?= Yii::t('db', 'seconds') ?></div>
    </div>
</div>



