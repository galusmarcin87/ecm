<?php

namespace app\models\mgcms\db;

/**
 * This is the ActiveQuery class for [[FileRelation]].
 *
 * @see FileRelation
 */
class FileRelationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return FileRelation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FileRelation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}