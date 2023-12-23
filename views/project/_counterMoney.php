<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
$model->language = Yii::$app->language;
if (!$model->money_full) {
    return false;
}

$percentage = round(($model->money / $model->money_full) * 100, 3);
?>

<div class="card-progress">
    <div class="row">
        <div class="col-6">
            <p><?= Yii::t('db', 'Collected') ?> (<?=$percentage?>%):</p>
            <p class="fs-6"><strong><?= MgHelpers::convertNumberToNiceString($model->money) ?>  PLN</strong></p>
        </div>
        <div class="col-6 text-end">
            <p><?= Yii::t('db', 'Goal') ?>:</p>
            <p class="fs-6"><?= MgHelpers::convertNumberToNiceString($model->money_full) ?> PLN</p>
        </div>
    </div>
    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $percentage?>" aria-valuemin="0"
         aria-valuemax="100">
        <div class="progress-bar" style="width: <?= $percentage?>%"></div>
    </div>

</div>
