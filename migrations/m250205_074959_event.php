<?php

use \app\components\migrations\ClickhouseMigration;

/**
* Class m250205_074959_event
*/
class m250205_074959_event extends ClickhouseMigration
{
    public function up()
    {
        $this->createTable('event', [
            'event_date' => 'DEFAULT toDate(unixtimestamp)',
            'unixtimestamp' => 'DateTime',
            'event_id' => $this->bigInteger()->unsigned(),
            'track_id' => $this->bigInteger()->unsigned(),
            'track_date' => 'DEFAULT toDate(track_time)',
            'track_time' => 'DateTime',

            'user_id' => $this->integer()->unsigned(),
            'offer_id' => $this->integer()->unsigned(),

            'event' => $this->string(),
            'event_data' => $this->string(),
            'subids' => 'Nested (param String, value String)',
        ], implode(' ', [
            'ENGINE = MergeTree()',
            'PARTITION BY toYYYYMM(event_date)',
            'ORDER BY (event_date, track_id, event)',
        ]));
    }

    public function down()
    {
        $this->dropTable('event');
    }
}
