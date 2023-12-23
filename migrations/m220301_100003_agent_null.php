<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220301_100003_agent_null extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('agent', 'description', $this->text() . ' NULL');
      $this->alterColumn('agent', 'phone', $this->string() . ' NULL');
      $this->alterColumn('agent', 'email', $this->string() . ' NULL');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
