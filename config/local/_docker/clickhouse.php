<?php
return [
    'class' => '\brntsrs\ClickHouse\Connection',
    'dsn' => '${DB_CLICKHOUSE_HOST_READ}',
    'dsnWrite' => '${DB_CLICKHOUSE_HOST_WRITE}',
    'port' => '${DB_CLICKHOUSE_PORT_READ}',
    'portWrite' => '${DB_CLICKHOUSE_PORT_WRITE}',
    'database' => '${DB_CLICKHOUSE_NAME}',
    'username' => '${DB_CLICKHOUSE_USER}',
    'password' => '${DB_CLICKHOUSE_PASSWORD}',
    'enableSchemaCache' => false,
    'schemaCache' => 'cache',
    'schemaCacheDuration' => 86400
];