<?php

return [
    'components' => [
        'db' => [
            //'class' => \yii\db\Connection::class,
            'class' => \common\config\db\NewConnection::class,
            //'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            //'username' => 'root',
            //'password' => '',
            'charset' => 'utf8',
            
            'dsn' => 'mysql:host=localhost;dbname=obiettivoscuola',
            'username' => 'paride',
            'password' => 'Spietato_001',            
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            // send all mails to a file by default.
            //'useFileTransport' => true,
            // You have to set
            //
            'useFileTransport' => false,
            //
            // and configure a transport for the mailer to send real emails.
            //
            // SMTP server example:
                'transport' => [
                    'scheme' => 'smtps',
                    'host' => 'smtps.aruba.it',
                    'username' => 'social@ricominciamoavivere.org',
                    'password' => 'Rubalino_01',
                    'port' => 465,
                    'dsn' => 'native://default',
                ],
            //
            // DSN example:
                'transport' => [
                    'dsn' => 'smtp://social@ricominciamoavivere.org:Rubalino_01@smtps.aruba.it:465',
                ],
            //
            // See: https://symfony.com/doc/current/mailer.html#using-built-in-transports
            // Or if you use a 3rd party service, see:
            // https://symfony.com/doc/current/mailer.html#using-a-3rd-party-transport
        ],
    ],
];
