<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250208_174929_statistcis_mobile
*/
class m250208_174929_statistcis_mobile extends ClickhouseMigration
{
    public function up()
    {
        $this->addColumn('statistics', 'geo_operator_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('statistics', 'geo_operator_id');
    }
}
