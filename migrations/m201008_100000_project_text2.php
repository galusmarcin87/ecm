<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m201008_100000_project_text2 extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('project', 'text2', $this->text());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
