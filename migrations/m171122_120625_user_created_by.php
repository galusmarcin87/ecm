<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m171122_120625_user_created_by extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addForeignKey('fk_user_user', 'user', 'created_by', 'user', 'id', 'SET NULL', 'NO ACTION');
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
