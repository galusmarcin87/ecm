<?php
use yii\db\Migration;

class m171122_185851_create_auth extends Migration
{

  public function up()
  {
    $this->execute("CREATE TABLE `auth` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `controller` VARCHAR(255) NOT NULL DEFAULT '0',
      `action` VARCHAR(255) NOT NULL DEFAULT '0',
      `role` VARCHAR(255) NOT NULL DEFAULT '0',
      `value` TINYINT(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    )
    ENGINE=InnoDB

    ;
    ");
  }

  public function down()
  {
    $this->dropTable('auth');
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
