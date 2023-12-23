<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210819_100000_user_is_corespondence extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'is_corespondence', $this->tinyInteger(1));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
