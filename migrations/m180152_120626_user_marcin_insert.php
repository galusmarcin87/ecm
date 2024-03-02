<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180152_120626_user_marcin_insert extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->execute('INSERT INTO `user` (`username`, `password`, `first_name`, `last_name`, `role`, `status`, `email`, `created_on`, `last_login`, `created_by`, `address`, `postcode`, `birthdate`, `city`, `auth_key`) VALUES (\'marcin\', \'$2y$13$FO3SoP7c..yHwC8QAPRvrOhqZ6//xx0RH.KNScPTSmqAmdDZ2mJ0a\', \'\', \'\', \'admin\', 1, \'\', NULL, \'2017-11-25 10:56:47\', NULL, \'\', \'\', NULL, \'\', \'\');');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    echo "m171121_120201_user cannot be reverted.\n";

    return false;
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
