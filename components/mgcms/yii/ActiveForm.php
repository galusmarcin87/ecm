<?php
namespace app\components\mgcms\yii;

use app\components\mgcms\yii\ActiveField;

class ActiveForm extends \yii\widgets\ActiveForm
{

  public $fieldClass = 'app\components\mgcms\yii\ActiveField';

  /**
   * @return ActiveField
   * @see fieldConfig
   */
  public function field($model, $attribute, $options = [])
  {
    return parent::field($model, $attribute, $options);
  }

  /**
   * @return ActiveField
   * @see fieldConfig
   */
  public function field12md($model, $attribute, $options = [])
  {
    $options['options']['class'] = 'col-md-12';
    return $this->field($model, $attribute, $options);
  }
  /**
   * @return ActiveField
   * @see fieldConfig
   */
  public function field6md($model, $attribute, $options = [])
  {
    $options['options']['class'] = 'col-md-6';
    return $this->field($model, $attribute, $options);
  }

  /**
   * @return ActiveField
   * @see fieldConfig
   */
  public function field4md($model, $attribute, $options = [])
  {
    $options['options']['class'] = 'col-md-4';
    return $this->field($model, $attribute, $options);
  }

  /**
   * @return ActiveField
   * @see fieldConfig
   */
  public function field3md($model, $attribute, $options = [])
  {
    $options['options']['class'] = 'col-md-3';
    return $this->field($model, $attribute, $options);
  }

  public static function beginFileForm()
  {
    return ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
  }

  public function relatedFileInput($model, $multiple = false, $imageOnly = false)
  {
    return $this->field($model, 'uploadedFiles[]')->fileInput(['multiple' => $multiple, 'accept' => $imageOnly === true ? '.jpg,.jpeg' : $imageOnly]);
  }
}
