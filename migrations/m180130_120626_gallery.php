<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180130_120626_gallery extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute("CREATE TABLE `gallery` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(245) NOT NULL,
	`slug` VARCHAR(245) NOT NULL,
	`created_on` TIMESTAMP NULL DEFAULT NULL,
	`created_by` INT(11) NULL,
	`order` INT(11) NULL DEFAULT NULL,
	`description` TEXT NULL,
	`promoted` TINYINT(1) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `name_UNIQUE` (`name`),
	UNIQUE INDEX `slug_UNIQUE` (`slug`),
	INDEX `fk_gallery_user1_idx` (`created_by`),
	CONSTRAINT `fk_gallery_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION ON DELETE SET NULL
)
;
");
    
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('gallery');
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
