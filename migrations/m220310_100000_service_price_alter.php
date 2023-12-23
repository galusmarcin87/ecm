<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220310_100000_service_price_alter extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('service', 'price', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
