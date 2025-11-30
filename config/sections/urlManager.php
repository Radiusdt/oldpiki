<?php
return [
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'normalizer' => [
        'class' => 'yii\web\UrlNormalizer',
        //'collapseSlashes' => true,
        'normalizeTrailingSlash' => true,
        //'action' => null,
    ],
    'rules'           => [
        't/<key>' => '/track/forward/index',
    ],
];