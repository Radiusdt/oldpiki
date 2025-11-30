<?php

use \yii\db\Migration;

/**
* Class m250427_052211_campaign_event_payment
*/
class m250427_052211_campaign_event_payment extends Migration
{
    public function safeUp()
    {
        $this->addColumn('campaign', 'payout_event_name', $this->string(50));
        $this->addColumn('offer', 'payment_event_name', $this->string(50));
    }

    public function safeDown()
    {
        $this->dropColumn('offer', 'payment_event_name');
        $this->dropColumn('campaign', 'payout_event_name');
    }
}
