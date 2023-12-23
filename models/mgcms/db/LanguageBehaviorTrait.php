<?php
namespace app\models\mgcms\db;

use yii\db\BaseActiveRecord;
use app\models\mgcms\db\AbstractRecord;

/**
 * @property array() $languageAttributes
 *
 */
trait LanguageBehaviorTrait
{

  public  $LANGUAGE_DEFAULT = 'pl';
  public $language;


  public function __get($name)
  {
    if(in_array($name, $this->languageAttributes) && $this->language && $this->language != $this->LANGUAGE_DEFAULT){
      return $this->getModelAttribute($name.'_'.$this->language);
    }
    return parent::__get($name);
  }


  public function save($runValidation = true, $attributeNames = NULL){
    if($this->language && !$this->isNewRecord && $this->language != $this->LANGUAGE_DEFAULT){
      foreach($this->languageAttributes as $attribute){
        $this->setModelAttribute($attribute.'_'.$this->language, $this->getAttribute($attribute));
        $this->setAttribute($attribute, $this->getOldAttribute($attribute));
      }
    }

    return parent::save($runValidation,$attributeNames);
  }
}
