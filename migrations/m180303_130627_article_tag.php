<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m180303_130627_article_tag extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->createTable('article_tag', [
        'article_id' => $this->integer(),
        'tag_id' => $this->integer(),
    ]);

    $this->addForeignKey('fk_article_article_tag', 'article_tag', 'article_id', 'article', 'id', 'CASCADE');
    $this->addForeignKey('fk_tag_article_tag', 'article_tag', 'tag_id', 'tag', 'id', 'CASCADE');
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropTable('article_tag');
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
