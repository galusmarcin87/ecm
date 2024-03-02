<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180202_120626_gallery_cover_file extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('gallery', 'file_id', $this->integer());
    $this->addForeignKey('fk_gallery_file', 'gallery', 'file_id', 'file', 'id');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropForeignKey('fk_gallery_file', 'gallery');
    $this->dropColumn('gallery', 'file_id');
  }
  /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
    echo "m171121_120201_user cannot be reverted.\n";

    return false;
    }
   */
}
