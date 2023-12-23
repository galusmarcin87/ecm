<?php
use yii\db\Migration;

class m171124_188888_user_status extends Migration
{

  public function up()
  {
    $this->execute("ALTER TABLE `user`
	CHANGE COLUMN `status` `status` TINYINT(3) NULL DEFAULT '1' AFTER `role`;
  UPDATE user SET status = 1;
    ");
  }

  public function down()
  {
    $this->dropTable('category');
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
