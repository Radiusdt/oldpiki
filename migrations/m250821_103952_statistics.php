<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250512_065052_source_integration
*/
class m250821_103952_statistics extends ClickhouseMigration
{
    public function up()
    {
        $this->addColumn('statistics', 'data_amount_first_deposit', $this->integer());
        $this->addColumn('statistics', 'data_amount_recurring_deposit', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('statistics', 'data_amount_first_deposit');
        $this->dropColumn('statistics', 'data_amount_recurring_deposit');
    }
}
