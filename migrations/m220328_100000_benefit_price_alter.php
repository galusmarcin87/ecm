<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220328_100000_benefit_price_alter extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('benefit', 'price', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
