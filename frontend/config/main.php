<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'favourite' => 'favourite/index',
                'favourite/add' => 'favourite/add',
                'favourite/delete' => 'favourite/delete',
                'favourite/count' => 'favourite/count',
                'compare' => 'compare/index',
                'compare/add' => 'compare/add',
                'compare/delete' => 'compare/delete',
                'compare/count' => 'compare/count',
                'cart' => 'cart/index',
                'cart/add' => 'cart/add',
                'cart/success/<md5Id>' => 'cart/success',
                'cart/update-count' => 'cart/update-count',
                'cart/remove' => 'cart/remove',
                'cart/minicart' => 'cart/minicart',
                'cart/reload-cart' => 'cart/reload-cart',
                'catalog/<alias>/<alias2>/<alias3>/<alias4>/<alias5>' => 'catalog/index',
                'catalog/<alias>/<alias2>/<alias3>/<alias4>' => 'catalog/index',
                'catalog/<alias>/<alias2>/<alias3>' => 'catalog/index',
                'catalog/<alias>/<alias2>' => 'catalog/index',
                'catalog/<alias>' => 'catalog/index',
                'catalog' => 'catalog/index',
                'product/<alias>' => 'catalog/view',
                '<alias>' => 'site/index',
            ],
        ],
    ],
    'params' => $params,
];
