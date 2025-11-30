<?php

use yii\db\Migration;

class m140703_123000_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'username' => $this->string(32),
            'login' => $this->string(20),
            'email' => $this->string()->notNull(),
            'access_token' => $this->string(40)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'oauth_client' => $this->string(),
            'oauth_client_user_id' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(\app\modules\user\enums\Status::NOT_ACTIVE->value),
            'status_moderation' => $this->smallInteger()->notNull()->defaultValue(\app\modules\user\enums\Moderation::WAITING->value),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'logged_at' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(0),
        ], $tableOptions);

        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->bigPrimaryKey()->unsigned(),
            'fullname' => $this->string(),
            'locale' => $this->string(32)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');

        $this->createIndex('username', 'user', 'username');
        $this->createIndex('access_token', 'user', 'access_token');

    }

    public function down()
    {
        $this->dropForeignKey('fk_user', '{{%user_profile}}');
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user}}');
    }
}
