<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220317_100000_agent_user_id extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->execute('ALTER TABLE `agent`
        ADD COLUMN `user_id` INT NOT NULL AFTER `company_id`,
        ADD INDEX `user_id` (`user_id`),
        ADD CONSTRAINT `fk_agent_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION ON DELETE NO ACTION;
    ');

      $this->execute("ALTER TABLE `agent`
        CHANGE COLUMN `full_name` `full_name` VARCHAR(245) NULL COLLATE 'utf8_general_ci' AFTER `id`,
        CHANGE COLUMN `position` `position` VARCHAR(245) NULL COLLATE 'utf8_general_ci' AFTER `full_name`;
    ");
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
