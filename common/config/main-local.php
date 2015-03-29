<?php
$db = parse_url(getenv("CLEARDB_DATABASE_URL"));
$config = [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ab-test',
            'username' => 'root',
            'password' => '310791',
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

$db = parse_url(getenv("CLEARDB_DATABASE_URL"));
if ($db) {
    $config['components']['db'] = [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=' . $db["host"] . 'dbname=' . substr($db["path"], 1),
        'username' => $db["user"],
        'password' => $db["pass"],
        'charset' => 'utf8',
    ];
}

return $config;