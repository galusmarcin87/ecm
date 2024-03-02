<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m190914_100000_project_token_currency extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('project', 'token_currency', $this->string('10'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
