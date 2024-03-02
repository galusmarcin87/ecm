<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m230407_100001_company_agent_code extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('company', 'agent_code', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
