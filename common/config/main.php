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
           'dateFormat' => 'd/m/Y',
           'datetimeFormat' => 'd/m/Y H:i', //'php:d-m-yyyy H:i', /*'dd-MM-Y H:i:s',*/
           'timeFormat' => 'H:i:s',

           'locale' => 'it-IT', //your language locale
           'defaultTimeZone' => 'Europe/Rome', // time zone
           //'saveTimezone' => 'UTC',
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
	        kartik\datecontrol\Module::FORMAT_DATE => [
        	        'class' => 'yii\jui\DatePicker', // example
                	'pluginOptions' => ['class'=>'form-control'],
            	],
	        kartik\datecontrol\Module::FORMAT_DATETIME => [
        	        'class' => '\kartik\datetime\DateTimePicker', // example
                	'options' => ['options' => ['class'=>'form-control']],
            	]
	     ],
             'displaySettings' => [
                    kartik\datecontrol\Module::FORMAT_DATE     => 'php:d/m/Y', //php:d-M-Y', /*'dd-MM-yyyy',*/
                    kartik\datecontrol\Module::FORMAT_TIME     => 'hh:mm:ss a',
                    kartik\datecontrol\Module::FORMAT_DATETIME => 'php:d/m/Y H:iP', //php:d-m-Y H:i:s', /*'dd-MM-yyyy hh:mm:ss a',*/
             ],
             // format settings for saving each date attribute (PHP format example)
             'saveSettings'    => [
                    kartik\datecontrol\Module::FORMAT_DATE     => 'php:U', // saves as unix timestamp
                    kartik\datecontrol\Module::FORMAT_TIME     => 'php:H:i:s',
                    kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
             ],
       
        ],    
    ]    
];
