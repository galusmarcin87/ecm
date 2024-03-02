<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m211223_100000_file_created_by extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->execute('ALTER TABLE `file`
	ADD COLUMN `created_by` INT NULL AFTER `created_on`,
	ADD INDEX `created_by` (`created_by`),
	ADD CONSTRAINT `fk_file_user` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION ON DELETE SET NULL;
');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
