<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180321_130628_category_language extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('category', 'language', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropColumn('category', 'language');
  }
}
