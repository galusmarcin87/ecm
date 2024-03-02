<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180926_100002_faq_item extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute("CREATE TABLE IF NOT EXISTS `faq_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question` TEXT NULL,
  `answer` TEXT NULL,
  `faq_id` INT NOT NULL,
  `order` INT(8) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_faq_item_faq1_idx` (`faq_id` ASC),
  CONSTRAINT `fk_faq_item_faq1`
    FOREIGN KEY (`faq_id`)
    REFERENCES `faq` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB");
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('project');
  }
}
