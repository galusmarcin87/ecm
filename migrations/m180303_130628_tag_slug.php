<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180303_130628_tag_slug extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('tag', 'slug', $this->string());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropColumn('tag', 'slug');
  }
}
