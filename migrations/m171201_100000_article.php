<?php
use yii\db\Migration;

class m171201_100000_article extends Migration
{

  public function up()
  {
    $this->execute("CREATE TABLE `article` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NULL DEFAULT NULL,
	`content` TEXT NULL,
	`slug` VARCHAR(255) NOT NULL,
	`excerpt` TEXT NULL,
	`language` VARCHAR(10) NULL DEFAULT NULL,
	`created_on` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`updated_on` TIMESTAMP NULL DEFAULT NULL,
	`meta_title` VARCHAR(245) NOT NULL,
	`meta_description` VARCHAR(245) NULL DEFAULT NULL,
	`meta_keywords` VARCHAR(245) NULL DEFAULT NULL,
	`status` VARCHAR(45) NULL DEFAULT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`updated_by` INT(11) NULL DEFAULT NULL,
	`parent_id` INT(11) NULL DEFAULT NULL,
	`category_id` INT(11) NULL DEFAULT NULL,
	`file_id` INT(11) NULL DEFAULT NULL,
	`order` INT(10) NULL DEFAULT '0',
	`promoted` TINYINT(1) NULL DEFAULT '0',
	`custom` TEXT NULL,
	`type` VARCHAR(255) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `id_UNIQUE` (`id`),
	UNIQUE INDEX `slug_UNIQUE` (`slug`),
	UNIQUE INDEX `title_UNIQUE` (`title`),
	INDEX `fk_article_user1_idx` (`created_by`),
	INDEX `fk_article_user2_idx` (`updated_by`),
	INDEX `fk_article_article1_idx` (`parent_id`),
	INDEX `fk_article_category1_idx` (`category_id`),
	INDEX `fk_article_file1_idx` (`file_id`),
	CONSTRAINT `fk_article_article1` FOREIGN KEY (`parent_id`) REFERENCES `article` (`id`) ON UPDATE NO ACTION ON DELETE SET NULL,
	CONSTRAINT `fk_article_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION,
	CONSTRAINT `fk_article_file1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON UPDATE NO ACTION ON DELETE SET NULL,
	CONSTRAINT `fk_article_user1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION ON DELETE SET NULL,
	CONSTRAINT `fk_article_user2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION ON DELETE SET NULL
)
ENGINE=InnoDB
;
");
  }

  public function down()
  {
    $this->dropTable('article');
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
