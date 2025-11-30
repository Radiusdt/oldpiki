<?php

use yii\db\Schema;
use yii\db\Migration;

class m160203_095604_user_token extends Migration
{
    public function up()
    {
        $this->createTable('{{%user_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(),
            'token' => $this->string(40)->notNull(),
            'expire_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'is_latest_in_use' => $this->boolean()->defaultValue(0),
        ]);
        $this->createIndex('user_id', 'user_token', 'user_id');
        $this->createIndex('is_latest_in_use', 'user_token', 'is_latest_in_use');
        $this->createIndex('token', 'user_token', ['token', 'type']);
    }

    public function down()
    {
        $this->dropTable('{{%user_token}}');
    }
}
