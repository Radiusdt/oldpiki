<?php

use \yii\db\Migration;

/**
* Class m250420_122028_advertiser
*/
class m250420_122028_advertiser extends Migration
{
    public function safeUp()
    {
        $this->createTable('advertiser', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'company_name' => $this->string(),
            'comment' => $this->text(),
            'status' => $this->integer()->defaultValue(1),
            'is_deleted' => $this->boolean()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('advertiser');
    }
}
