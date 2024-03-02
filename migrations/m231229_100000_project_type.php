<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m231229_100000_project_type extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('project','type',$this->string(25));

  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }

}
