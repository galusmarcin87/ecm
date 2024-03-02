<?php

use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220721_100000_payment_changes extends Migration
{

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE `payment`
	CHANGE COLUMN `project_id` `company_id` INT(11) NULL AFTER `created_on`,
	ADD COLUMN `rate` INT(3) NULL DEFAULT NULL AFTER `status`,
	ADD COLUMN `rel_id` INT(11) NOT NULL AFTER `rate`,
	ADD COLUMN `type` VARCHAR(50) NOT NULL AFTER `rel_id`,
	DROP COLUMN `percentage`,
	DROP COLUMN `is_preico`,
	DROP COLUMN `user_token`,
	DROP INDEX `fk_payment_project1_idx`,
	DROP FOREIGN KEY `fk_payment_project1`;
');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {

    }
}
