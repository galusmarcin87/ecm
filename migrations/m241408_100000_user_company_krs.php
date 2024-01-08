<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m241408_100000_user_company_krs extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('user', 'company_krs', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
