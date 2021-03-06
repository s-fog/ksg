<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['queue_default', 'queue_sync'],
    'components' => [
        'cache' => [
            'class' => 'yii\redis\Cache',
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
            'hostname' => 'ksg_redis',
            'port' => 6379,
            'retries' => 2,
        ],
        'queue_default' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis',
            'ttr' => 100,
            'attempts' => 3,
            'as log' => \yii\queue\LogBehavior::class
        ],
        'queue_sync' => [
            'class' => \yii\queue\sync\Queue::class,
            'handle' => true,
        ],
    ],
];
