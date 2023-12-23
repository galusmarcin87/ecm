<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220301_100000_jobs_addres_null extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('job', 'address', $this->string().' NULL');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
