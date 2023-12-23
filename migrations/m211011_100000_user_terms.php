<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m211011_100000_user_terms extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('user','acceptTerms5', $this->integer(1));
      $this->addColumn('user','acceptTerms6', $this->integer(1));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
