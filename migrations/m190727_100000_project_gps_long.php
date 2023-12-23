<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m190727_100000_project_gps_long extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('project', 'gps_long', $this->decimal('10,8'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
