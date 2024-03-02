<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210918_100000_project_value extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('project', 'value', $this->integer());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
