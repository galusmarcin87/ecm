<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\mgcms\db\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\components\mgcms\MgHelpers;
use yii\bootstrap\Tabs;

$fieldConfig = \app\components\ProjectHelper::getFormFieldConfig(false);

?>

<section class="Section Section--big-padding-top accountSettings">


    <div class="row">
        <div class="col-md-6">
            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
                'class' => 'fadeInUpShort animated delay-250',
                'fieldConfig' => $fieldConfig
            ]);

            //          echo $form->errorSummary($model);
            ?>

            <div class="row">
                <div class="col-md-8"><?= $form->field($model, 'email')->textInput() ?></div>
                <div class="col-md-4">
                    <button class="btn inputFit"
                            onclick="return confirm('<?= Yii::t('db', 'Are you sure to make changes?') ?>')">
                        <?= Yii::t('db', 'Change') ?>
                    </button>
                </div>
            </div>

            <?php ActiveForm::end(); ?>


            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',
                'class' => 'fadeInUpShort animated delay-250',
                'fieldConfig' => $fieldConfig
            ]);

            //          echo $form->errorSummary($model);
            ?>
            <h3><?= Yii::t('db', 'Password') ?></h3>
            <?= $form->field($model, 'oldPassword')->passwordInput(['placeholder' => Yii::t('db', 'Old password')]) ?>
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('db', 'New password')]) ?>
            <?= $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => Yii::t('db', 'Password repeat')]) ?>

            <button type="submit" class="btn btn-success btn-block" name="passwordChanging"
                    onclick="return confirm('<?= Yii::t('db', 'Are you sure to make changes?') ?>')">
                <?= Yii::t('db', 'Save changes') ?>
            </button>

            <?php ActiveForm::end(); ?>
        </div>


        <div class="col-md-2 offset-2">
            <?php
            $form = ActiveForm::begin([
                'id' => 'login-form',

                'fieldConfig' => \app\components\ProjectHelper::getFormFieldConfig(true),
                'options' => ['enctype' => 'multipart/form-data', 'class' => 'animatedParent',]
            ]);

            //          echo $form->errorSummary($model);
            ?>
            <div class="User-Photo ">
                <div class="text-center">
                    <h5>
                        <?= Yii::t('db', 'PROFILE PHOTO'); ?>
                    </h5>
                    <? if (!$model->file_id): ?>
                        <img src="/images/avatar_03.jpg" alt=""/>
                    <? else: ?>
                        <img src="<?= $model->file->getImageSrc(210, 210) ?>" alt=""/>
                    <? endif; ?>
                    <div class="buttonWrapper top10 bottom10">
                        <?= \kartik\widgets\FileInput::widget([
                            'name' => 'User[file_id]',
                            'pluginOptions' => [
                                'showCaption' => false,
                                'showRemove' => false,
                                'showUpload' => false,
                                'showPreview' => false,

                                'browseClass' => '',
//                                    'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                'browseLabel' => Yii::t('db', 'UPLOAD PHOTO +')
                            ],
                            'options' => ['accept' => 'image/*']
                        ]);
                        ?>
                        <a href="<?= \yii\helpers\Url::to(['site/remove-photo']) ?>" class="removeBtn">
                            <?= Yii::t('db', 'REMOVE PHOTO -'); ?>
                        </a>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-block top10" name="imageSave"
                        onclick="return confirm('<?= Yii::t('db', 'Are you sure to make changes?') ?>')">
                    <?= Yii::t('db', 'Save changes') ?>
                </button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


</section>
