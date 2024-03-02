<?php

namespace app\models\mgcms\db;

/**
 * This is the ActiveQuery class for [[I18nMessage]].
 *
 * @see I18nMessage
 */
class I18nMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return I18nMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return I18nMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}