<?php

use yii\db\Migration;

class m171122_185751_create_column_auth_key_user extends Migration {

    public function up() {
        $this->addColumn('user', 'auth_key', $this->string(60)->notNull()->unique());
    }

    public function down() {
//        $this->dropColumn('user', 'auth_key');
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
