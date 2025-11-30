<?php
return [
    'class' => '\brntsrs\ClickHouse\Connection',
    'dsn' => 'db_clickhouse',
    'dsnWrite' => 'db_clickhouse_bulk',
    'port' => '8123',
    'portWrite' => '8124',
    'database' => 'project',
    'username' => 'default',
    'password' => '',
    'enableSchemaCache' => false,
    'schemaCache' => 'cache',
    'schemaCacheDuration' => 86400
];