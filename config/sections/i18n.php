<?php
return [
    'translations' => [
        'yii' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru-RU',
            'basePath' => '@yii/messages',
        ],
        '*' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'ru-RU',
            'basePath' => '@yii/messages',
        ],
       /* '*' => [
            'class' => 'yii\i18n\DbMessageSource',
            'sourceMessageTable' => '{{%translate_source_message}}',
            'messageTable' => '{{%translate_message}}',
//            'enableCaching' => true,
//            'cachingDuration' => 3600
        ]*/
    ],
];
