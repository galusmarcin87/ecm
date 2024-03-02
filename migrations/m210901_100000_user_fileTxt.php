<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210901_100000_user_fileTxt extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('user', 'file_text', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
