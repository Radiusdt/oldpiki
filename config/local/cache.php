<?php
return [
    'class' => 'yii\caching\MemCache',
    'keyPrefix' => 'mem',
    'useMemcached' => true,
    'servers' => [
        [
            'host' => 'db_memcached',
            'port' => 11211,
        ],
    ],
];