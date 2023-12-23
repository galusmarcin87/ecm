<?php

namespace app\models\mgcms\db;

use \app\models\mgcms\db\base\I18nMessage as BaseI18nMessage;

/**
 * This is the model class for table "i18n_message".
 */
class I18nMessage extends BaseI18nMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id', 'language'], 'required'],
            [['id'], 'integer'],
            [['translation'], 'string'],
            [['language'], 'string', 'max' => 16]
        ]);
    }
	
}
