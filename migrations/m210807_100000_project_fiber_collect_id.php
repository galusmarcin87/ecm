<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210807_100000_project_fiber_collect_id extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('project', 'fiber_collect_id', $this->string(15));

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
