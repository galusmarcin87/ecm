<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180303_130626_tag extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->createTable('tag', [
        'id' => $this->primaryKey(),
        'name' => $this->string(),
        'json' => $this->text(),
    ]);
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('tag');
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
