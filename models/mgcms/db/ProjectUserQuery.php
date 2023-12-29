<?php

namespace app\models\mgcms\db;

/**
 * This is the ActiveQuery class for [[ArticleTag]].
 *
 * @see ProjectUser
 */
class ProjectUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ProjectUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
