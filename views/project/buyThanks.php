<?php
/* @var $model app\models\mgcms\db\Project */

use app\components\mgcms\MgHelpers;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $form app\components\mgcms\yii\ActiveForm */

$this->title = Yii::t('db', 'Thank you for investition');

?>

<?= $this->render('/common/breadcrumps') ?>

<div class="text-page">
    <div class="container">
        <div class="text-page-intro">
            <div class="row">
                <?= MgHelpers::getSettingTypeText('buy thank you text 1' . Yii::$app->language, true, '<p>buy thank you text 1</p>') ?>

                <a href="<?= \yii\helpers\Url::to('/site/complete-attorney')?>" class="btn btn-primary"><?= Yii::t('db', 'Complete the power of attorney    ') ?></a>

                <?= MgHelpers::getSettingTypeText('buy thank you text 2' . Yii::$app->language, true, '<p>buy thank you text 2</p>') ?>
            </div>
        </div>
    </div>
</div>
