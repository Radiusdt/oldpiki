<?php

use \yii\db\Migration;

/**
* Class m250420_122203_offer
*/
class m250420_122203_offer extends Migration
{
    public function safeUp()
    {
        $this->createTable('offer', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'advertiser_id' => $this->integer(),
            'description' => $this->text(),
            'url_forward' => $this->text(),
            'status' => $this->integer()->defaultValue(1),
            'image_url' => $this->string(),
            'country_ids' => $this->json(),
            'payment_amount' => $this->float(),
            'payment_currency_id' => $this->integer(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('offer');
    }
}
