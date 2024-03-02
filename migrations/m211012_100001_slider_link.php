<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m211012_100001_slider_link extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('slide', 'link', $this->string());

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('slide', 'link');
        return true;

    }
    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m171121_120201_user cannot be reverted.\n";

      return false;
      }
     */
}
