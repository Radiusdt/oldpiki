<?php
require 'common.php';

return (new ConfigGenerator([
    'components' => [
        'errorHandler' => [
            'class' => 'app\components\ErrorHandlerWeb',
        ],
        'request' => null,
        'response' => null,
        'httpBasicAuth' => null,
        'redis' => null,
        'user' => null,
        'assetManager' => null,
    ],
    'modules' => null,
    'container' => null,
]))->getFullConfig();
