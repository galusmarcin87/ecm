<?php

use \yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
$model = new \app\models\LoginForm();
?>

<div id="Login-box" class="Login-box mfp-hide">
    <div class="Login-box__close mfp-close">&#215;</div>
    <img class="Login-box__logo" src="/images/menu_logo.png" alt=""/>
    <div class="Login-box__content">
        <h6 class="Login-box__heading"><?= Yii::t('db', 'Log into service'); ?></h6>
        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
        ]);
        ?>
        <div class="User-Panel__form-group User-Panel__form-group--block">
            <div>
                <div class="Form__group form-group">
                    <input
                            class="Form__input form-control"
                            placeholder="&nbsp;"
                            name="LoginForm[username]"
                            type="text"
                            required
                    />
                    <label class="Form__label" for="phone"><?= Yii::t('db', 'Login'); ?></label>
                </div>
            </div>
        </div>
        <div class="User-Panel__form-group User-Panel__form-group--block">
            <div>
                <div class="Form__group form-group">
                    <input
                            class="Form__input form-control"
                            placeholder="&nbsp;"
                            name="LoginForm[password]"
                            type="password"
                            required
                    />
                    <label class="Form__label" for="phone"><?= Yii::t('db', 'Password'); ?></label>
                </div>
            </div>
        </div>
        <input
                class="btn btn-success btn-block Login-box__submit"
                type="submit"
                value="<?= Yii::t('db', 'LOG IN'); ?>"
        />
        <?= Html::a(Yii::t('db', 'Forgotten password?'), ['site/forgot-password']) ?>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="Login-box__footer">
        <?= Yii::t('db', 'You do not have account? Register.'); ?>
        <a
                href="<?= \yii\helpers\Url::to(['site/register'])?>"
                class="btn btn-success btn-block close-popup"

        ><?= Yii::t('db', 'REGISTER'); ?></a
        >
    </div>
</div>