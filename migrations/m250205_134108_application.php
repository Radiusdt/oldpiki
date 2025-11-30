<?php

use \yii\db\Migration;

/**
* Class m250205_134108_application
*/
class m250205_134108_application extends Migration
{
    public function safeUp()
    {
        $this->createTable('application', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'package' => $this->string(),
            'store_type' => $this->tinyInteger(),
            'store_data' => $this->json(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'install_costs' => $this->json(),
            'install_costs_currency_id' => $this->integer(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('application');
    }
}
