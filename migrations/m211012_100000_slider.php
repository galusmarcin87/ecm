<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m211012_100000_slider extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `slider` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(245) NOT NULL COLLATE 'utf8_general_ci',
            `language` VARCHAR(45) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
            PRIMARY KEY (`id`) USING BTREE
            )
            COLLATE='utf8_general_ci'
            ENGINE=InnoDB
            ;
            ");
        $this->execute("CREATE TABLE `slide` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(245) NOT NULL COLLATE 'utf8_general_ci',
            `header` VARCHAR(245) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
            `subheader` VARCHAR(245) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
            `body` TEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
            `file_id` INT(11) NULL DEFAULT NULL,
            `slider_id` INT(11) NOT NULL,
            `order` INT(5) NULL DEFAULT NULL,
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `fk_slide_file1_idx` (`file_id`) USING BTREE,
            INDEX `fk_slide_slider1_idx` (`slider_id`) USING BTREE,
            CONSTRAINT `fk_slide_file1` FOREIGN KEY (`file_id`) REFERENCES `file` (`id`) ON UPDATE NO ACTION ON DELETE SET NULL,
            CONSTRAINT `fk_slide_slider1` FOREIGN KEY (`slider_id`) REFERENCES `slider` (`id`) ON UPDATE NO ACTION ON DELETE CASCADE
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB
        ;
        
        ");

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('slide');
        $this->dropTable('slider');
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
