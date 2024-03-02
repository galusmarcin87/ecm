<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m181003_100000_setting_system extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {

    $this->addColumn('setting', 'type', $this->string(50));
    $this->execute('UPDATE setting set type = "system"');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
