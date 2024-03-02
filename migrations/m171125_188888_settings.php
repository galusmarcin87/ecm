<?php
use yii\db\Migration;

class m171125_188888_settings extends Migration
{

  public function up()
  {
    $this->execute("CREATE TABLE `setting` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`key` VARCHAR(255) NULL DEFAULT NULL,
	`value` TEXT NULL,
	`value_text` TEXT NULL,
	PRIMARY KEY (`id`)
)
ENGINE=InnoDB
;
");
  }

  public function down()
  {
    $this->dropTable('setting');
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
