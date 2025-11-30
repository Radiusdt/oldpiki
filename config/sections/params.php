<?php

return [
    'adminEmail' => 'admin@example.com',
    'robotEmail' => 'noreply@xheavy.tech',
    "yii.migrations" => [
        "@vendor/pheme/yii2-settings/migrations",
    ],
    'openexchangeRatesKey' => '9b8cea492bd04a8b831e508377b882f1',
    'phpUser' => 'www-data',
    'urlSchema' => 'http',
    'defaultDomain' => 'parser.local',
    'devMode' => true,
    'cloudflare' => [
        'dns_ip' => '',
        'email' => '',
        'key' => '',
    ],
    'godaddy' => [
        'is_production_mode' => false,
        'key' => '',
        'secret' => '',
    ],
    'onesignal' => [
        'token' => '',
        'app_id' => '',
        'user_key' => '',
        'organisation_key' => '',
        'organisation_id' => '',
    ],
];
