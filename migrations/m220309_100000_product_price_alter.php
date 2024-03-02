<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220309_100000_product_price_alter extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('product', 'price', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
