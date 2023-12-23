<?

use app\models\mgcms\db\Project;
use yii\web\View;
use yii\helpers\Url;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */
/* @var $model app\models\mgcms\db\Project */

if(!$model->money_full){
    return false;
}
$percentage = round(($model->money / $model->money_full) * 100, 3);
?>

<div class="campaign-progress">
    <div class="row">
        <div class="col-6">
            <p class="label"><?= Yii::t('db', 'Collected') ?> (<?=$percentage?>%):</p>
            <p class="amount amount--current"><?= MgHelpers::convertNumberToNiceString($model->money) ?> $</p>
        </div>
        <div class="col-6 text-end">
            <p class="label"><?= Yii::t('db', 'Goal') ?>:</p>
            <p class="amount amount--target"><?= MgHelpers::convertNumberToNiceString($model->money_full) ?> $</p>
        </div>
    </div>
    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="<?= $percentage?>"
         aria-valuemin="0" aria-valuemax="100">
        <div class="progress-bar" style="width: <?= $percentage?>%"></div>
    </div>

</div>
