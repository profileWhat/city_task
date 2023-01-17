<?php
$ip_plugin = [
    'plugin_url' => 'http://www.geoplugin.net/{{accepted_formats}}.gp?ip={{ip}}',
    'accepted_formats'          => ['json', 'php', 'xml'],
    'default_accepted_format'   => 'php',
];


return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'geo' => [
            'class' => div\geoip\Geo::class,
            'cityClass' => 'common\models\City' // модель города
        ],
        'geolocation' => [
            'class' => rodzadra\geolocation\Geolocation::class,
            'config' => [
                'plugin' => $ip_plugin,
            ],
        ],
        'citySearch' => [
            'class' => common\components\GeoCitySearch::class,
            'config' => [
                'plugin_url' => 'https://htmlweb.ru/json/geo/search/?tbl=city&search={{cityName}}&api_key={{api_key}}',
                'api_key' =>'009a83a9abf337b1dfcfbd8435df0bad'
            ]
        ],
        'cityAdapter' => [
            'class' => common\components\CityAdapter::class
        ]
    ],
];
