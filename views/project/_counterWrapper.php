<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
$model->language = Yii::$app->language;
?>


<? if ($model->money_full): ?>
    <div class="counter-wrapper">
        <div class="counter">
            <div class="counter__line"
                 style="width: <?= round(($model->money / $model->money_full) * 100, 0) ?>%"></div>
        </div>
    </div>
<? endif; ?>



