<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220307_100000_company_is_benefit extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('company','is_benefit', $this->tinyInteger(1));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
