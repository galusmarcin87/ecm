<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m181015_100001_project_buy_token_info extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('project', 'buy_token_info', $this->text());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropColumn('project', 'buy_token_info');
  }
}
