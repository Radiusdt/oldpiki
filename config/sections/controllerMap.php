<?php
return [
    'stubs' => [
        'class' => 'bazilio\stubsgenerator\StubsController',
    ],
    'clickhouse' => [
        'class' => '\brntsrs\ClickHouse\ClickhouseController'
    ],
    'migrate' => [
        'class' => 'app\commands\MigrateController',
    ],
    'queue' => [
        'class' => 'app\schedule\components\controllers\QueueController',
    ],
    'crontab' => [
        'class' => 'app\schedule\components\controllers\CrontabController',
    ],
];