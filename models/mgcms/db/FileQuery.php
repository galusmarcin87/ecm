<?php

namespace app\models\mgcms\db;

use rmrevin\yii\module\File\models\queries\FileQuery as rmrevinFileQuery;
/**
 * This is the ActiveQuery class for [[File]].
 *
 * @see File
 */
class FileQuery extends rmrevinFileQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return File[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return File|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}