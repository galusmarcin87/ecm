<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180926_100000_project extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute("CREATE TABLE IF NOT EXISTS `project` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(245) NOT NULL,
  `status` VARCHAR(45) NULL,
  `localization` VARCHAR(245) NULL,
  `gps_lat` DECIMAL(10,8) NULL,
  `gps_long` DECIMAL(10,9) NULL,
  `lead` TEXT NULL,
  `text` TEXT NULL,
  `file_id` INT(11) NOT NULL,
  `whitepaper` VARCHAR(245) NULL,
  `www` VARCHAR(245) NULL,
  `money` DOUBLE(9,2) NULL,
  `money_full` DOUBLE(9,2) NULL,
  `investition_time` VARCHAR(45) NULL,
  `percentage` INT(4) NULL,
  `date_presale_start` DATE NULL,
  `date_presale_end` DATE NULL,
  `date_crowdsale_start` DATE NULL,
  `date_crowdsale_end` DATE NULL,
  `percentage_presale_bonus` INT(4) NULL,
  `date_realization_profit` DATE NULL,
  `token_value` INT(6) NULL,
  `token_blockchain` VARCHAR(245) NULL,
  `token_to_sale` INT(10) NULL,
  `token_minimal_buy` INT(10) NULL,
  `token_left` INT(10) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_project_file1_idx` (`file_id` ASC),
  CONSTRAINT `fk_project_file1`
    FOREIGN KEY (`file_id`)
    REFERENCES `file` (`id`)
    ON DELETE NO ACTION
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
