<?php
require 'common.php';

return (new ConfigGenerator([
    'controllerNamespace' => 'app\commands',

    'controllerMap' => null,
    'components' => [
        'errorHandler' => [
            'class' => 'app\components\ErrorHandlerConsole',
        ],
    ]
]))->getFullConfig();
