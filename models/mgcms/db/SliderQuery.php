<?php

namespace app\models\mgcms\db;
use app\components\mgcms\MgHelpers;

/**
 * This is the ActiveQuery class for [[Slider]].
 *
 * @see Slider
 */
class SliderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Slider[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Slider|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}