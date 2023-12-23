<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180926_100001_faq extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute("CREATE TABLE IF NOT EXISTS `faq` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(245) NULL,
  `lang` VARCHAR(5) NULL,
  `type` INT(3) NULL,
  PRIMARY KEY (`id`))
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
