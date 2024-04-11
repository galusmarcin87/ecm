<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m240411_100000_payment_engine extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('payment', 'engine', $this->string(255));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
