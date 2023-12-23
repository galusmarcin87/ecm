<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m171121_120625_user extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute('CREATE TABLE `user` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(245) NOT NULL,
	`password` VARCHAR(245) NOT NULL,
	`first_name` VARCHAR(245) NULL DEFAULT NULL,
	`last_name` VARCHAR(245) NULL DEFAULT NULL,
	`role` VARCHAR(45) NULL DEFAULT NULL,
	`status` TINYINT(3) NULL DEFAULT NULL,
	`email` VARCHAR(245) NULL DEFAULT NULL,
	`created_on` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`last_login` TIMESTAMP NULL DEFAULT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`address` VARCHAR(245) NULL DEFAULT NULL,
	`postcode` VARCHAR(245) NULL DEFAULT NULL,
	`birthdate` DATE NULL DEFAULT NULL,
	`city` VARCHAR(245) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `username_UNIQUE` (`username`)
)
ENGINE=InnoDB;
');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    echo "m171121_120201_user cannot be reverted.\n";

    return false;
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
