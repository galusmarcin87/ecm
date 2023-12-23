<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m190824_100000_user_phone extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('user','phone', $this->string(20));

  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
      $this->dropColumn('user','phone');
  }
}
