<?php

use \yii\db\Migration;

/**
* Class m250205_075425_track_and_event_id
*/
class m250205_075425_track_and_event_id extends Migration
{
    public function safeUp()
    {
        $this->createTable('track_temporary', [
            'id' => $this->bigPrimaryKey(),
        ]);
        $this->createTable('event_temporary', [
            'id' => $this->bigPrimaryKey(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('track_temporary');
        $this->dropTable('event_temporary');
    }
}
