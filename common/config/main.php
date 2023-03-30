<?php
return [
    'language' => 'it-IT', //your language locale
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'formatter' => [
           'dateFormat' => 'dd/MM/yyyy',
           'datetimeFormat' => 'php:d-m-yyyy H:i:s', /*'dd-MM-Y H:i:s',*/
           'timeFormat' => 'H:i:s',

           'locale' => 'it-IT', //your language locale
           'defaultTimeZone' => 'Europe/Rome', // time zone
        ],         
    ],
   
];
