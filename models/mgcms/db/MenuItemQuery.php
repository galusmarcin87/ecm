<?php

namespace app\models\mgcms\db;

/**
 * This is the ActiveQuery class for [[MenuItem]].
 *
 * @see MenuItem
 */
class MenuItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MenuItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MenuItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}