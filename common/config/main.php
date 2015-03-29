<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            /*'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>'
            ],*/
        ],

        /*'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>'
            ],
        ],*/
    ],
];
