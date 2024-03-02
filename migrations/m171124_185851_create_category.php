<?php
use yii\db\Migration;

class m171124_185851_create_category extends Migration
{

  public function up()
  {
    $this->execute("CREATE TABLE `category` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(245) NOT NULL,
	`slug` VARCHAR(245) NOT NULL,
	`type` VARCHAR(245) NULL DEFAULT NULL,
	`parent_id` INT(11) NULL DEFAULT NULL,
	`order` INT(10) NULL DEFAULT '0',
	`promoted` TINYINT(1) NULL DEFAULT '0',
	`custom` TEXT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_category_category1_idx` (`parent_id`),
	CONSTRAINT `fk_category_category1` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION
)
ENGINE=InnoDB
;
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
