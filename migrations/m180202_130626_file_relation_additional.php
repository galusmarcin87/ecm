<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180202_130626_file_relation_additional extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('file_relation', 'order', $this->integer());
    $this->addColumn('file_relation', 'json', $this->text());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropColumn('file_relation', 'order');
    $this->dropColumn('file_relation', 'json');
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
