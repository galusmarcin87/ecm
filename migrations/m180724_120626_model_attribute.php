<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180724_120626_model_attribute extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {

    $this->createTable('model_attribute', [
        'rel_id' => $this->integer(),
        'model' => $this->string(),
        'key' => $this->string(),
        'value' => $this->text()
    ]);

    $this->addPrimaryKey('model_attribute_pk', 'model_attribute', ['rel_id', 'model', 'key']);
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('model_attribute');
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
