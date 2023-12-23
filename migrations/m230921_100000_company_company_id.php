<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m230921_100000_company_company_id extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('company', 'company_id', $this->integer());
      $this->addForeignKey('company_company_fk', 'company','company_id','company','id');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
