<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250212_105122_statistics_params
*/
class m250212_105122_statistics_params extends ClickhouseMigration
{
    public function up()
    {
        $this->dropColumn('track','user_device_id');
        $this->addColumn('track', 'user_device_id', $this->string(5));
        $this->dropColumn('track','user_os_id');
        $this->addColumn('track', 'user_os_id', $this->string(5));
        $this->dropColumn('track','user_browser_id');
        $this->addColumn('track', 'user_browser_id', $this->string(5));
        $this->addColumn('track', 'user_device_brand_id', $this->string(5));

        $this->dropTable('statistics');
        $this->createTable('statistics', [
            'event_date' => 'DEFAULT toDate(unixtimestamp)',
            'unixtimestamp' => 'DateTime',

            'track_id' => $this->bigInteger(),
            'track_date' => 'DEFAULT toDate(track_time)',
            'track_time' => 'DateTime',
            'event_id' => $this->bigInteger(),

            'geo_country_id' => $this->integer()->unsigned(),
            'geo_operator_id' => $this->integer()->unsigned(),
            'geo_region_id' => $this->integer()->unsigned(),
            'geo_city_id' => $this->integer()->unsigned(),
            'domain_id' => $this->integer()->unsigned(),

            'user_id' => $this->integer()->unsigned(),
            'offer_id' => $this->integer()->unsigned(),
            'source_id' => $this->integer()->unsigned(),

            'user_ip' => $this->string()->unsigned(),
            'user_ip_integer' => $this->integer(),
            'user_agent' => $this->string(),
            'user_device_id' => $this->string(5),
            'user_device_brand_id' => $this->string(5),

            'user_os_id' => $this->string(5),
            'user_os_version' => $this->string(),
            'user_browser_id' => $this->string(5),

            'subids' => 'Nested (param String, value String)',

            'data_amount_click' => $this->smallInteger(),
            'data_amount_event' => $this->smallInteger(),
            'data_amount_install' => $this->smallInteger(),
            'data_amount_reg' => $this->smallInteger(),
            'data_amount_deposit' => $this->smallInteger(),
            'data_amount_open' => $this->smallInteger(),
            'data_amount_sub' => $this->smallInteger(),

        ], implode(' ', [
                'ENGINE = MergeTree()',
                'PARTITION BY toYYYYMM(event_date)',
                'ORDER BY (event_date, user_id, offer_id, source_id, geo_country_id, user_os_id, domain_id)',
            ])
        );
    }

    public function down()
    {
        $this->dropColumn('track','user_device_id');
        $this->addColumn('track', 'user_device_id', $this->smallInteger()->unsigned());
        $this->dropColumn('track','user_os_id');
        $this->addColumn('track', 'user_os_id', $this->smallInteger()->unsigned());
        $this->dropColumn('track','user_browser_id');
        $this->addColumn('track', 'user_browser_id', $this->smallInteger()->unsigned());
        $this->dropColumn('track', 'user_device_brand_id');

        $this->dropTable('statistics');
        $this->createTable('statistics', [
            'event_date' => 'DEFAULT toDate(unixtimestamp)',
            'unixtimestamp' => 'DateTime',

            'track_id' => $this->bigInteger(),
            'track_date' => 'DEFAULT toDate(track_time)',
            'track_time' => 'DateTime',
            'event_id' => $this->bigInteger(),

            'geo_country_id' => $this->integer()->unsigned(),
            'geo_operator_id' => $this->integer()->unsigned(),
            'geo_region_id' => $this->integer()->unsigned(),
            'geo_city_id' => $this->integer()->unsigned(),
            'domain_id' => $this->integer()->unsigned(),

            'user_id' => $this->integer()->unsigned(),
            'offer_id' => $this->integer()->unsigned(),
            'source_id' => $this->integer()->unsigned(),

            'user_ip' => $this->string()->unsigned(),
            'user_ip_integer' => $this->integer(),
            'user_agent' => $this->string(),
            'user_device_id' => $this->smallInteger(),

            'user_os_id' => $this->smallInteger()->unsigned(),
            'user_os_version' => $this->string(),
            'user_browser_id' => $this->smallInteger()->unsigned(),

            'subids' => 'Nested (param String, value String)',

            'data_amount_click' => $this->smallInteger(),
            'data_amount_event' => $this->smallInteger(),
            'data_amount_install' => $this->smallInteger(),
            'data_amount_reg' => $this->smallInteger(),
            'data_amount_deposit' => $this->smallInteger(),
            'data_amount_open' => $this->smallInteger(),
            'data_amount_sub' => $this->smallInteger(),

        ], implode(' ', [
                'ENGINE = MergeTree()',
                'PARTITION BY toYYYYMM(event_date)',
                'ORDER BY (event_date, user_id, offer_id, source_id, geo_country_id, user_os_id)',
            ])
        );
    }
}
