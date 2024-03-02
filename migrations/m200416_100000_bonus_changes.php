<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m200416_100000_bonus_changes extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute("ALTER TABLE `bonus`
	CHANGE COLUMN `from` `from` VARCHAR(255) NOT NULL DEFAULT '' AFTER `id`,
	CHANGE COLUMN `value` `value` TEXT NOT NULL DEFAULT '' AFTER `to`;");
    $this->execute("ALTER TABLE `bonus`
	ALTER `to` DROP DEFAULT;
ALTER TABLE `bonus`
	CHANGE COLUMN `to` `to` INT(10) NULL AFTER `from`;");
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('bonus');
  }
}
