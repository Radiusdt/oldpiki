<?php
return [
    'class' => 'yii\caching\MemCache',
    'keyPrefix' => 'mem',
    'useMemcached' => true,
    'servers' => [
        [
            'host' => '${DB_MEMCACHED_HOST}',
            'port' => 11211,
        ],
    ],
];