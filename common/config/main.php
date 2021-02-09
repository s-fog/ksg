<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/cache',
        ],
        'cart' => [
            'class' => 'yz\shoppingcart\ShoppingCart'
        ],
        'i18n' => [
            'translations' => [
                'models*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/i18n',
                ],
                'giiant*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/i18n',
                ],
                'cruds*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/i18n',
                ],
            ],
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => 'localhost',
            'port' => 6379,
            'retries' => 2,
        ],
        'queue_default' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis',
            'ttr' => 20,
            'attempts' => 3,
            'as log' => \yii\queue\LogBehavior::class
        ],
    ],
];
