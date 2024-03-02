<?php
namespace app\components\mgcms;

class MgcmsFormatter extends \yii\i18n\Formatter
{

  public function asTranslate($value)
  {
    return \Yii::t('app', $value);
  }

  public function asSize($value, $decimals = NULL, $options = [], $textOptions = [])
  {
    return MgHelpers::getFormatedFileSize($value);
  }

    public function asNumberSeparatedWithSpace($value)
    {
        return number_format($value, 2, '.', ' ');
    }
}
