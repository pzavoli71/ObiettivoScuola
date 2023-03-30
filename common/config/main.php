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
        'assetManager' => [
        'bundles' => [
            'kartik\form\ActiveFormAsset' => [
                'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
            ],
        ],
    ],
    ],
   'modules'    => [
    'datecontrol' => [
        'class'          => 'kartik\datecontrol\Module',
        'widgetSettings' => [
            'displaySettings' => [
                kartik\datecontrol\Module::FORMAT_DATE     => 'dd-MM-yyyy',
                kartik\datecontrol\Module::FORMAT_TIME     => 'hh:mm:ss a',
                kartik\datecontrol\Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm:ss a',
            ],
            // format settings for saving each date attribute (PHP format example)
            'saveSettings'    => [
                kartik\datecontrol\Module::FORMAT_DATE     => 'php:U', // saves as unix timestamp
                kartik\datecontrol\Module::FORMAT_TIME     => 'php:H:i:s',
                kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
        ]
    ], 
],    
];
