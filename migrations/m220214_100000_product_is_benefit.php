<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220214_100000_product_is_benefit extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('product','is_benefit', $this->tinyInteger(1));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
