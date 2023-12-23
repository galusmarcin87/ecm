<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220111_100000_company_form_of_business extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('company','sale_form_of_business', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
