<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220318_100000_user_description_position extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('user', 'description', $this->text());
      $this->addColumn('user', 'position', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
