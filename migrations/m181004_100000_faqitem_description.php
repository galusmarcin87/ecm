<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m181004_100000_faqitem_description extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
    $this->addColumn('faq_item', 'content', $this->text());
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {
    $this->dropColumn('faq_item', 'content');
  }
}
