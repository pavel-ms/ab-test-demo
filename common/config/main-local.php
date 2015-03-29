<?php
$config = [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=us-cdbr-iron-east-02.cleardb.net;dbname=heroku_00b38916f2b7e87',
            'username' => 'ba92bc7ab46c19',
            'password' => 'fa55c4b7',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];

/*$db = parse_url(getenv("CLEARDB_DATABASE_URL"));
if ($db) {
    $config['components']['db'] = [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=' . $db["host"] . 'dbname=' . substr($db["path"], 1),
        'username' => $db["user"],
        'password' => $db["pass"],
        'charset' => 'utf8',
    ];
}*/

return $config;