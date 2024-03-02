<?$required = isset($required) ? $required : true;?>
<div class="form-group text-left">
    <input type="hidden" name="RegisterForm[acceptTerms<?=$number?>]" value="0">
    <input
            name="RegisterForm[acceptTerms<?=$number?>]"
            class="Form__checkbox"
            type="checkbox"
            id="agree<?=$number?>"
            value="1"
            <?= $required ? 'required' : ''?>
    />
    <label for="agree<?=$number?>" >
        <?= \app\components\mgcms\MgHelpers::getSettingTranslated('register_terms_label'.$number, ' zgoda '.$number) ?>
    </label>
    <?= \yii\helpers\Html::error($modelRegister, 'acceptTerms'.$number,['class'=>'help-block-error']); ?>
</div>
