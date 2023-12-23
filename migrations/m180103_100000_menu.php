<?php
use yii\db\Migration;

class m180103_100000_menu extends Migration
{

  public function up()
  {
    $this->execute("CREATE TABLE `menu` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(245) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
CREATE TABLE `menu_item` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`url` VARCHAR(245) NULL DEFAULT NULL,
	`label` VARCHAR(245) NULL DEFAULT NULL,
	`order` INT(11) NULL DEFAULT NULL,
	`menu_id` INT(11) NOT NULL,
	`parent_id` INT(11) NULL DEFAULT NULL,
	`article_id` INT(11) NULL DEFAULT NULL,
	`category_id` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_menu_item_menu1_idx` (`menu_id`),
	INDEX `fk_menu_item_menu_item1_idx` (`parent_id`),
	INDEX `fk_menu_item_article1_idx` (`article_id`),
	INDEX `fk_menu_item_category1_idx` (`category_id`),
	CONSTRAINT `fk_menu_item_article1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE,
	CONSTRAINT `fk_menu_item_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE,
	CONSTRAINT `fk_menu_item_menu1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE,
	CONSTRAINT `fk_menu_item_menu_item1` FOREIGN KEY (`parent_id`) REFERENCES `menu_item` (`id`) ON UPDATE NO ACTION ON DELETE SET NULL
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;

");
  }

  public function down()
  {
    $this->dropTable('menu');
    $this->dropTable('menu_item');
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
