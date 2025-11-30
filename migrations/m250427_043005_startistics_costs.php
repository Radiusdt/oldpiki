<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250427_043005_startistics_costs
*/
class m250427_043005_startistics_costs extends ClickhouseMigration
{
    public function up()
    {
        $this->addColumn('statistics', 'payment_in_amount', $this->float());
        $this->addColumn('statistics', 'payment_in_amount_usd', $this->float());
        $this->addColumn('statistics', 'payment_in_currency_id', $this->integer());

        $this->addColumn('statistics', 'payment_out_amount', $this->float());
        $this->addColumn('statistics', 'payment_out_amount_usd', $this->float());
        $this->addColumn('statistics', 'payment_out_currency_id', $this->integer());

        $this->addColumn('statistics', 'payment_revenue_amount', $this->float());
        $this->addColumn('statistics', 'payment_revenue_amount_usd', $this->float());

        $this->addColumn('event', 'payment_in_amount', $this->float());
        $this->addColumn('event', 'payment_in_amount_usd', $this->float());
        $this->addColumn('event', 'payment_in_currency_id', $this->integer());

        $this->addColumn('event', 'payment_out_amount', $this->float());
        $this->addColumn('event', 'payment_out_amount_usd', $this->float());
        $this->addColumn('event', 'payment_out_currency_id', $this->integer());

        $this->addColumn('event', 'payment_revenue_amount', $this->float());
        $this->addColumn('event', 'payment_revenue_amount_usd', $this->float());
    }

    public function down()
    {
        $this->dropColumn('statistics', 'payment_in_amount');
        $this->dropColumn('statistics', 'payment_in_amount_usd');
        $this->dropColumn('statistics', 'payment_in_currency_id');

        $this->dropColumn('statistics', 'payment_out_amount');
        $this->dropColumn('statistics', 'payment_out_amount_usd');
        $this->dropColumn('statistics', 'payment_out_currency_id');

        $this->dropColumn('statistics', 'payment_revenue_amount');
        $this->dropColumn('statistics', 'payment_revenue_amount_usd');

        $this->dropColumn('event', 'payment_in_amount');
        $this->dropColumn('event', 'payment_in_amount_usd');
        $this->dropColumn('event', 'payment_in_currency_id');

        $this->dropColumn('event', 'payment_out_amount');
        $this->dropColumn('event', 'payment_out_amount_usd');
        $this->dropColumn('event', 'payment_out_currency_id');

        $this->dropColumn('event', 'payment_revenue_amount');
        $this->dropColumn('event', 'payment_revenue_amount_usd');
    }
}
