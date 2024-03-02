<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m190719_100001_bonus extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute("CREATE TABLE IF NOT EXISTS `bonus` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `from` INT(10) NOT NULL,
  `to` INT(10) NOT NULL,
  `value` INT(10) NOT NULL,
  `project_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_bonus_project1_idx` (`project_id` ASC),
  CONSTRAINT `fk_bonus_project1`
    FOREIGN KEY (`project_id`)
    REFERENCES `project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB");
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('bonus');
  }
}
