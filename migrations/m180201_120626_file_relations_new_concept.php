<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180201_120626_file_relations_new_concept extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->dropColumn('file', 'rel_id');
    $this->dropColumn('file', 'model');

    $this->createTable('file_relation', [
        'file_id' => $this->integer(),
        'rel_id' => $this->integer(),
        'model' => $this->string()
    ]);

    $this->addPrimaryKey('file_relation_pk', 'file_relation', ['file_id', 'rel_id', 'model']);
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('file_relation');
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
