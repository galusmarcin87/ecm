<?php

namespace app\components;

use Yii;
use app\models\mgcms\db\Setting;

/**
 * Helpers class
 * @author marcin
 */
class ProjectHelper extends \yii\base\Component
{

    static function getFormFieldConfig($withPlaceholders = true)
    {
        if ($withPlaceholders) {
            return [
                'options' => [
                    'class' => "Contact-form__label",
                ],
                'template' => "{input}\n{error}",
                'inputOptions' => ['class' => 'form-control'],
                'labelOptions' => [
                    'class' => "form-control",
                ],
                'wrapperOptions' => [
                    'class' => "form-control",
                ]
            ];
        } else {
            return [
                'options' => [
                    'class' => "Contact-form__label",
                ],
                'template' => "{beginWrapper}{label}{input}\n\n{error}{endWrapper}",
                'inputOptions' => ['class' => 'form-control'],
                'labelOptions' => [
                    'class' => "form-control",
                ],
                'wrapperOptions' => [
//                    'class' => "form-control",

                ]
            ];
        }
    }

    static function getFormFieldConfigMyAccount()
    {

            return [
                'options' => [
                    'class' => "Contact-form__label",
                ],
                'template' => "{input}\n{error}",
                'inputOptions' => ['class' => 'input full-width'],
                'labelOptions' => [
                    'class' => "Form__label",
                ],
                'wrapperOptions' => [
                    'class' => "Form__group  form-group",
                ]
            ];
    }
}
