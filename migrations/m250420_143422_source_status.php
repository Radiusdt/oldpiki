<?php

use \yii\db\Migration;

/**
* Class m250420_143422_source_status
*/
class m250420_143422_source_status extends Migration
{
    public function safeUp()
    {
        $this->addColumn('source', 'status', $this->tinyInteger()->notNull()->defaultValue(0));
        $this->addColumn('source', 'is_deleted', $this->boolean()->notNull()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('source', 'status');
        $this->dropColumn('source', 'is_deleted');
    }
}
