<?php
/* @var $this yii\web\View */

/* @var $model \app\models\mgcms\db\User */

use app\components\mgcms\yii\ActiveForm;
use app\components\mgcms\MgHelpers;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

$this->title = Yii::t('db', 'Settings');

$google2fa = new Google2FA();
$google2faSecret = $model->getModelAttribute('google2faSecret');

if(!$google2faSecret){
    $google2faSecret = $google2fa->generateSecretKey();
    $model->setModelAttribute('google2faSecret',$google2faSecret);
}

$g2faUrl = $google2fa->getQRCodeUrl(
    'ECM',
    '2FA',
    $google2faSecret
);

$writer = new Writer(
    new ImageRenderer(
        new RendererStyle(400),
        new ImagickImageBackEnd()
    )
);

$qrcode_image = base64_encode($writer->writeString($g2faUrl));

?>

<?= $this->render('/common/breadcrumps', ['displayBg' => true, 'cssClass' => 'page-header-text', ]) ?>
<?= $this->render('_investor') ?>

<div class="account-page">
    <div class="container">
        <img src="<?= $qrcode_image ?>">
        <div class="row gx-4">
            <?= $this->render('_leftNav', ['tab' => $tab]) ?>
            <div class="col-lg-9 account-content-col">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'class' => 'fadeInUpShort animated delay-250',
                    //'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(false)
                ]);
                echo $form->errorSummary($model);
                ?>
                <div class="account-data-block mb-3">
                    <div class="row">
                     <h4 class="font-oswald fw-bold mb-4">
                        <?= Yii::t('db', 'Google Two-Factor Authentication') ?>
                    </h4>
                    <img src="data:image/png;base64, <?= $qrcode_image?>">
                    <h4 class="font-oswald mb-4">
                        <?= $form->field($model, 'is2faEnabled')->switchInput() ?>
                    </h4>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary"><?= Yii::t('db', 'Save changes') ?></button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
		<div class="col-lg-9 account-content-col">
			 <h4 class="font-oswald fw-bold mb-4">
                        <?= Yii::t('db', 'Change password') ?>
            </h4>
                <?php
                $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'class' => 'form-light',
                    'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(true)
                ]);
                echo $form->errorSummary($model);
                ?>
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <?= $form->field($model, 'oldPassword')->passwordInput(['placeholder' => $model->getAttributeLabel('oldPassword')]) ?>
                            <?= $form->field($model, 'newPassword')->passwordInput(['placeholder' => $model->getAttributeLabel('newPassword')]) ?>
                            <?= $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => $model->getAttributeLabel('passwordRepeat')]) ?>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" name="passwordChanging" class="btn btn-primary"><?= Yii::t('db', 'Save changes') ?></button>
                    </div>
                <?php ActiveForm::end(); ?>
         </div>
    </div>
</div><br><br><br><br>