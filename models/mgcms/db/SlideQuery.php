<?php

namespace app\models\mgcms\db;
use app\components\mgcms\MgHelpers;

/**
 * This is the ActiveQuery class for [[Slide]].
 *
 * @see Slide
 */
class SlideQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Slide[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Slide|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}