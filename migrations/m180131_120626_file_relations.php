<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180131_120626_file_relations extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('file', 'rel_id', $this->integer());
    $this->addColumn('file', 'model', $this->string(255));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropColumn('file', 'rel_id');
    $this->dropColumn('file', 'model');
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
