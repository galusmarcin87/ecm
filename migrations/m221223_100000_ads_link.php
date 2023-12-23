<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m221223_100000_ads_link extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('ad','link',$this->string());

  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
