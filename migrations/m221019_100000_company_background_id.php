<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m221019_100000_company_background_id extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('company','background_id', $this->integer(11)->null());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
