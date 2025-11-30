<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250427_050315_event_campaign
*/
class m250427_050315_event_campaign extends ClickhouseMigration
{
    public function up()
    {
        $this->addColumn('event', 'campaign_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('event', 'campaign_id');
    }
}
