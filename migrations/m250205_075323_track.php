<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250205_075323_track
*/
class m250205_075323_track extends ClickhouseMigration
{
    public function up()
    {
        $this->createTable('track', [
            'event_date' => 'DEFAULT toDate(unixtimestamp)',
            'unixtimestamp' => 'DateTime',

            'track_id' => $this->bigInteger(),
            'geo_country_id' => $this->integer(),
            'geo_region_id' => $this->integer(),
            'geo_city_id' => $this->integer(),

            'user_id' => $this->integer()->unsigned(),
            'offer_id' => $this->integer()->unsigned(),
            'source_id' => $this->integer()->unsigned(),

            'url_current' => $this->string(),
            'url_forward' => $this->string(),
            'url_referrer' => $this->string(),

            'user_ip' => $this->string(),
            'user_ip_integer' => $this->integer()->unsigned(),
            'user_agent' => $this->string(),
            'user_device_id' => $this->smallInteger()->unsigned(),

            'user_os_id' => $this->smallInteger()->unsigned(),
            'user_os_version' => $this->string(),
            'user_browser_id' => $this->smallInteger()->unsigned(),

            'subids' => 'Nested (param String, value String)',

        ], implode(' ', [
                'ENGINE = MergeTree()',
                'PARTITION BY toYYYYMM(event_date)',
                'ORDER BY (event_date, track_id)',
            ])
        );
    }

    public function down()
    {
        $this->dropTable('track');
    }
}
