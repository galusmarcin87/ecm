<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m230921_100000_looking_for extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('company', 'looking_for', $this->text());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
