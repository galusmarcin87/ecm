<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m230407_100002_company_stripe_price extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('company', 'stripe_price_id', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
