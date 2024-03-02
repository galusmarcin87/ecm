<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220301_100001_jobs_alter_null extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('job', 'info', $this->text() . ' NULL');
      $this->alterColumn('job', 'requirements', $this->text() . ' NULL');

      $this->alterColumn('job', 'salary', $this->string(30) . ' NULL');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
