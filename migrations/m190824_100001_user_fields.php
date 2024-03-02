<?php
use yii\db\Migration;

/**
 * Class m171121_120201_user
 */
class m190824_100001_user_fields extends Migration
{

  /**
   * @inheritdoc
   */
  public function safeUp()
  {
      $this->addColumn('user','file_id', $this->integer(11));
      $this->addForeignKey('user_file_fx', 'user','file_id','file','id');

      $this->addColumn('user','country', $this->string(30));
      $this->addColumn('user','voivodeship', $this->string(30));
      $this->addColumn('user','street', $this->string(50));
      $this->addColumn('user','flat_no', $this->string(10));
      $this->addColumn('user','citizenship', $this->string(30));
      $this->addColumn('user','id_document_type', $this->string(30));
      $this->addColumn('user','id_document_no', $this->string(30));
      $this->addColumn('user','pesel', $this->string(30));
  }

  /**
   * @inheritdoc
   */
  public function safeDown()
  {

  }
}
