<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210827_100000_project_percentage extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('project', 'percentage', $this->double('6,2'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
