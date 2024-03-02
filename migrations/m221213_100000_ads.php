<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m221213_100000_ads extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->createTable('ad',[
          'id' => 'INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
          'name' => $this->string(255),
          'status' => $this->string(25),
          'date_to' => $this->timestamp(),
          'country' => $this->string(255),
          'file_id' => $this->integer(),
      ]);
      $this->addForeignKey('ad_FK1', 'ad','file_id','file','id');

  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
