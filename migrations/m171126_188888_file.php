<?php
use yii\db\Migration;

class m171126_188888_file extends Migration
{

  public function up()
  {
    $this->addColumn('file', 'created_on', 'TIMESTAMP');
  }

  public function down()
  {
    $this->dropColumn('file', 'created_on');
  }
  /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
   */
}
