<?php

use \yii\db\Migration;

/**
* Class m250208_173027_source
*/
class m250208_173027_source extends Migration
{
    public function safeUp()
    {
        $this->createTable('source', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'internal_name' => $this->string(20),
            'detect_by_param' => $this->string(20),
            'detect_by_param_value' => $this->string(20),
        ]);

        $this->insert('source', [
            'name' => 'Direct',
            'internal_name' => 'direct',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('source');
    }
}
