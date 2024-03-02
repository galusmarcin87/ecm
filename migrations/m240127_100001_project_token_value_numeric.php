<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m240127_100001_project_token_value_numeric extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('project', 'token_value', $this->float(9,2));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
