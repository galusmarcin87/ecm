<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m230407_100000_user_agent_code extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('user', 'agent_code', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
