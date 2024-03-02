<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m190912_100000_project_value extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('project', 'money', $this->double('12,2'));
        $this->alterColumn('project', 'money_full', $this->double('12,2'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
