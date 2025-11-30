<?php

use \yii\db\Migration;

/**
* Class m250210_083416_team
*/
class m250210_083416_team extends Migration
{
    public function safeUp()
    {
        $this->createTable('team', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->addColumn('user', 'team_id', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'team_id');
        $this->dropTable('team');
    }
}
