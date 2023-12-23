<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m210827_100001_project_presale_bonuse extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('project', 'percentage_presale_bonus', $this->double('6,2'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
