<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m240111_100000_user_is_verified extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('user', 'is_verified', $this->boolean());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
