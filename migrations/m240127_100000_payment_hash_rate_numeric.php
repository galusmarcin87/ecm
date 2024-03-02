<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m240127_100000_payment_hash_rate_numeric extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('payment', 'hash', $this->string(255));
      $this->alterColumn('payment', 'rate', $this->float(9,2));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
