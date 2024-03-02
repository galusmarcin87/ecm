<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m181016_100000_payment extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute("CREATE TABLE IF NOT EXISTS `payment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_on` TIMESTAMP NULL,
  `project_id` INT NOT NULL,
  `user_id` INT(11) NOT NULL,
  `amount` FLOAT(16,6) NULL,
  `status` VARCHAR(45) NULL,
  `percentage` FLOAT(6,2) NULL,
  `is_preico` TINYINT(1) NULL,
  `user_token` VARCHAR(245) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_payment_project1_idx` (`project_id` ASC),
  INDEX `fk_payment_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_payment_project1`
    FOREIGN KEY (`project_id`)
    REFERENCES `project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_payment_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB");
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('payment');
  }
}
