<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250512_073649_event_source
*/
class m250512_073649_event_source extends ClickhouseMigration
{
    public function up()
    {
        $this->addColumn('event', 'source_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('event', 'source_id');
    }
}
