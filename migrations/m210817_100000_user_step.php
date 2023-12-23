<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210817_100000_user_step extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'step', $this->string(10));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
