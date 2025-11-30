<?php
namespace app\components\migrations;

use yii\db\Migration;

class ClickhouseMigration extends Migration
{
    public function init()
    {
        parent::init();
        $this->db = \Yii::$app->clickhouse;
    }

    public function safeUp()
    {
        return $this->up();
    }

    public function safeDown()
    {
        return $this->down();
    }

    public function createTable($table, $columns, $options = null)
    {
        if (is_array($options)) {
            $options = implode("\n", array_map(function ($name, $value) {
                if (is_array($value)) {
                    $value = '(' . implode(', ', $value) . ')';
                }
                return '    ' . strtoupper(str_replace('_', ' ', $name)) . ' ' . $value;
            }, array_keys($options), $options));
            $options = "\n" . $options;
        }
        return parent::createTable($table, $columns, $options);
    }
}