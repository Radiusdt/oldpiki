<?php

use yii\db\Migration;

/**
 * Class m191113_184758_currency
 */
class m191113_184758_currency extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('currency', [
            'id' => $this->primaryKey(),
            'iso' => $this->string(3),
            'rate' => $this->float(),
            'is_default' => $this->boolean()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('currency');
    }
}
