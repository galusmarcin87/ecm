<?
use app\models\mgcms\db\Project;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model Project */
$cssPrefixClass = isset($cssPrefixClass) ? $cssPrefixClass : 'portfolio';
?>
<div class="row">
    <div class="col-md-6">
        <div class="<?=$cssPrefixClass?>-icons">
            <div class="<?=$cssPrefixClass?>-icons-icon">
                <svg class="icon">
                    <use xlink:href="#calendar"/>
                </svg>
            </div>
            <div class="<?=$cssPrefixClass?>-icons-text">
                <?= $model->investition_time ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="<?=$cssPrefixClass?>-icons">
            <div class="<?=$cssPrefixClass?>-icons-icon">
                <svg class="icon">
                    <use xlink:href="#procent"/>
                </svg>
            </div>
            <div class="<?=$cssPrefixClass?>-icons-text">
                <?= $model->percentage ?>% <?= Yii::t('db', 'of return') ?>
            </div>
        </div>
    </div>
</div>
