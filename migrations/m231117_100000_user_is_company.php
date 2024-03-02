<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m231117_100000_user_is_company extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('user', 'is_company', $this->integer());

  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
