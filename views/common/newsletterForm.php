<?

use yii\bootstrap\ActiveForm;
use yii\web\View;
use app\components\mgcms\MgHelpers;

/* @var $this yii\web\View */

?>
<div class="container fadeIn animated">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <h3 class="Header-icon">
                <?= Yii::t('db', 'Newsletter'); ?>
                <img class="Header-icon__icon" src="/svg/znaczek.svg" alt=""/>
            </h3>
            <div class="animatedParent">
                <?php $form = ActiveForm::begin(['id' => 'newsletter-form', 'class' => 'fadeIn animated']); ?>
                <div class="Newsletter__inner">
                    <div class="Form__group form-group">
                        <input
                                class="Form__input form-control"
                                placeholder="&nbsp;"
                                id="phone"
                                name="newsletterEmail"
                                type="phone"
                                required
                        />
                        <label class="Form__label" for="phone"
                        ><?= Yii::t('db', 'Enter your email address'); ?></label
                        >
                        <input
                                class="btn btn-primary lowercase"
                                type="submit"
                                value="<?= Yii::t('db', 'Sign in'); ?>"
                        />
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>