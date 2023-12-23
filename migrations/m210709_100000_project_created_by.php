<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210709_100000_project_created_by extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('project', 'created_by', $this->integer(11));
        $this->addForeignKey('fk_user_project', 'project', 'created_by', 'user', 'id', 'SET NULL', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
