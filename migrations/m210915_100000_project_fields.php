<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210915_100000_project_fields extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('project', 'iban', $this->string(255));
        $this->addColumn('project', 'pay_description', $this->string(255));
        $this->addColumn('project', 'pay_name', $this->string(255));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
