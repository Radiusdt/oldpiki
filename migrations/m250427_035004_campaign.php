<?php

use \yii\db\Migration;

/**
* Class m250427_035004_campaign
*/
class m250427_035004_campaign extends Migration
{
    public function safeUp()
    {
        $this->createTable('campaign', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'source_id' => $this->integer(),
            'offer_id' => $this->integer(),
            'key' => $this->string(5)->notNull(),
            'user_id' => $this->integer(),
            'subid1' => $this->string(50),
            'subid2' => $this->string(50),
            'subid3' => $this->string(50),
            'subid4' => $this->string(50),
            'subid5' => $this->string(50),
            'offer_cap' => $this->integer()->unsigned(),
            'offer_cap_reach' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'payout_amount' => $this->float(),
            'payout_currency_id' => $this->integer(),
            'payout_type' => $this->boolean(),
            'comment' => $this->text(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),

            'is_deleted' => $this->boolean()->notNull()->defaultValue(0),
        ]);
        $this->createIndex('is_deleted', 'campaign', 'is_deleted');

        $this->createIndex('campaign_key', 'campaign', 'key', true);
    }

    public function safeDown()
    {
        $this->dropTable('campaign');
    }
}
