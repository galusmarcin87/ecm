<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m231229_100000_bonus_language extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('bonus','language',$this->string(10));

  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }

}
