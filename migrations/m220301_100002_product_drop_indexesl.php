<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220301_100002_product_drop_indexesl extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->dropIndex('price_UNIQUE','product');
      $this->dropIndex('number_UNIQUE','product');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
