<?

use app\components\mgcms\MgHelpers;
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $model Project */
/* @var $this yii\web\View */
$model->language = Yii::$app->language;
?>


    <div class="counter-header">
        <div class="counter-header__source">
            <span class="counter-header__source__value"><?= $model->money ?></span>
            PLN
        </div>
        <div class="counter-header__target"><?= $model->money_full ?> PLN</div>
    </div>

