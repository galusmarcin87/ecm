<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\RegisterForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\mgcms\MgHelpers;

$this->title = Yii::t('db', 'Complete the power of attorney');

?>

<?= $this->render('/common/breadcrumps'); ?>

<div class="container">

    <div class="row">
        <div class="col-lg-6">
            <h3><?= Yii::t('db', 'Electronic signature') ?></h3>
            <p><?= Yii::t('db', 'Waiting time about 3 minutes') ?></p>
            <p>
                <a class="btn btn-primary"
                   href="<?= MgHelpers::getSetting('wzor pełnomocnictwa ' . Yii::$app->language) ?>">
                    <?= Yii::t('db', 'Power of attorney template') ?>
                </a>
            </p>
            <?= MgHelpers::getSetting('podpis elektroniczny text ' . Yii::$app->language, true, 'podpis elektroniczny text') ?>

        </div>
        <div class="col-lg-6">
            <h3><?= Yii::t('db', 'Physical signature') ?></h3>
            <p><?= Yii::t('db', 'Waiting time about 1 week') ?></p>
            <p>
                <a class="btn btn-primary"
                   href="<?= MgHelpers::getSetting('wzor pełnomocnictwa ' . Yii::$app->language) ?>">
                    <?= Yii::t('db', 'Power of attorney template') ?>
                </a>
            </p>
            <?= MgHelpers::getSetting('podpis fizyczny text ' . Yii::$app->language, true, 'podpis fizyczny text') ?>
        </div>
    </div>

</div>
