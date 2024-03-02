<?php

namespace app\models\mgcms\db;

/**
 * This is the ActiveQuery class for [[I18nSourceMessage]].
 *
 * @see I18nSourceMessage
 */
class I18nSourceMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return I18nSourceMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return I18nSourceMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}