<?php

namespace app\models\mgcms\db;

use \app\models\mgcms\db\base\Setting as BaseSetting;

/**
 * This is the base model class for table "setting".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property string $value_text
 * @property string $type
 */
class Setting extends BaseSetting
{
  const TYPE_TEXT = 'text';
  const TYPE_SYSTEM = 'system';
  const TYPES = [
      self::TYPE_TEXT,
      self::TYPE_SYSTEM
  ];
    /**
     * @inheritdoc
     */

}
