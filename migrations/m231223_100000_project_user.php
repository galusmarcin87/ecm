<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m231223_100000_project_user extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->createTable('project_user', [
        'project_id' => $this->integer(),
        'user_id' => $this->integer(),
    ]);

    $this->addForeignKey('fk_project_project_user', 'project_user', 'project_id', 'project', 'id', 'CASCADE');
    $this->addForeignKey('fk_user_project_user', 'project_user', 'user_id', 'user', 'id', 'CASCADE');

    $this->addPrimaryKey('pk_project_user','project_user',['project_id','user_id']);
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('project_user');
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
