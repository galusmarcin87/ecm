<?php

namespace app\components\mgcms\yii;

use Yii;
use dosamigos\ckeditor\CKEditor;
use app\extensions\mgcms\yii2TinymceWidget\TinyMce;
use kartik\widgets\FileInput;
use \app\components\mgcms\MgHelpers;
use kartik\switchinput\SwitchInput;
use \yii\helpers\ArrayHelper;

class ActiveField extends \yii\widgets\ActiveField
{

    public function datePicker()
    {
        return $this->widget(\kartik\datecontrol\DateControl::classname(), [
            'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
            'saveFormat' => 'php:Y-m-d',
            'ajaxConversion' => true,
            'options' => [
                'pluginOptions' => [
                    'placeholder' => Yii::t('app', Yii::t('app', 'Choose ' . $this->model->getAttributeLabel($this->attribute))),
                    'autoclose' => true
                ]
            ],
        ]);
    }

    public function dateTimePicker()
    {
        return $this->widget(\kartik\widgets\DateTimePicker::classname(), [
            'options' => [
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd HH:ii:ss',
                    'autoclose' => true
                ],]
        ]);
    }

    public function ckeditor()
    {
        return $this->widget(CKEditor::className(), [
//            'options' => ['rows' => 6],
        ]);
    }

    /**
     *
     * @param array $options
     */
    public function tinyMce($clientOptions = [], $options = [])
    {
        return $this->widget(TinyMce::className(), MgHelpers::getTinyMceOptions($clientOptions, $options));
    }

    public function fileInputPretty($options = [])
    {
        return $this->widget(FileInput::classname(), [
            'options' => $options,
        ]);
    }

    public function switchInput($options = [])
    {
        return $this->widget(SwitchInput::classname(), ArrayHelper::merge($options, [
            'type' => SwitchInput::CHECKBOX,
            'pluginOptions' => [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]])
        );
    }

    public function dropdownFromSettings($name, $empty = false)
    {
        $options = [];
        if ($empty) {
            $options['prompt'] = '';
        }
        return $this->dropDownList(MgHelpers::getSettingOptionArray($name), $options);
    }

    public function languageDropdown()
    {
        return $this->dropDownList(array_combine(MgHelpers::getConfigParam('languages'), MgHelpers::getConfigParam('languages')));
    }
}
