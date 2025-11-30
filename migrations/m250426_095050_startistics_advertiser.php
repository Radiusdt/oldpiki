<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250426_095050_startistics_advertiser
*/
class m250426_095050_startistics_advertiser extends ClickhouseMigration
{
    public function up()
    {
        $this->addColumn('statistics', 'advertiser_id', $this->integer());
        $this->addColumn('track', 'advertiser_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('track', 'advertiser_id');
        $this->dropColumn('statistics', 'advertiser_id');
    }
}
