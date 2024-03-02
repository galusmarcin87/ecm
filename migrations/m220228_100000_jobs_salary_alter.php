<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m220228_100000_jobs_salary_alter extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->alterColumn('job', 'salary', $this->string('30'));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
