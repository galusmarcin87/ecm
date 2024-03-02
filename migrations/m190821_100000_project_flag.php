<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m190821_100000_project_flag extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('project','flag_id', $this->integer(11));

    $this->addForeignKey('project_flag_fx', 'project','flag_id','file','id');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
      $this->dropColumn('project','flag_id');
  }
}
