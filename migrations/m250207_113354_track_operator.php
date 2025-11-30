<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250207_113354_track_operator
*/
class m250207_113354_track_operator extends ClickhouseMigration
{
    public function up()
    {
        $this->addColumn('track', 'geo_operator_id', $this->integer()->unsigned());
    }

    public function down()
    {
        $this->dropColumn('track', 'geo_operator_id');
    }
}
