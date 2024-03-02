<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m190719_000000_user_language extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('user', 'language', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropColumn('user', 'language');
  }
}
