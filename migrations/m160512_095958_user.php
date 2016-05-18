<?php

date_default_timezone_set("Asia/Bangkok");

use yii\db\Migration;
use yii\db\Schema;

class m160512_095958_user extends Migration {

    public function up() {
        $this->createTable('user', [
            'user_id' => Schema::TYPE_PK,
            'user_name' => Schema::TYPE_STRING . ' NOT NULL',
            //'user_auth_key' => Schema::TYPE_STRING,
            'user_password' => Schema::TYPE_STRING . ' NOT NULL',
            //'user_password_reset_token' => Schema::TYPE_STRING,
            'user_email' => Schema::TYPE_STRING . ' NOT NULL',
            //'user_role' => Schema::TYPE_SMALLINT,
            'user_status' => Schema::TYPE_SMALLINT,
            'user_created_at' => Schema::TYPE_TIMESTAMP,
            'user_updated_at' => Schema::TYPE_TIMESTAMP,
        ]);

        $this->createIndex('user_name', 'user', 'user_name', true);
        $this->createIndex('user_email', 'user', 'user_email', true);

        $this->batchInsert('user', ['user_name', 'user_password', 'user_email', 'user_status', 'user_created_at'],
        [['admin', Yii::$app->security->generatePasswordHash('passw0rd-2015'), 'sales@mangpood.com', 1, date("Y-m-d H:i:s")],
        ['poyecud37', Yii::$app->security->generatePasswordHash('123456789'), 'poyecud37@yahoo.com', 1, date("Y-m-d H:i:s")]
        ]);
    }

    public function down() {
        
        $this->dropTable('user');
        
        //echo "m160512_095958_user cannot be reverted.\n";
        //return false;
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
