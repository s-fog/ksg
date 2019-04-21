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
    'bootstrap' => ['assetsAutoCompress', 'log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'assetsAutoCompress' =>
            [
                'class'                         => '\skeeks\yii2\assetsAuto\AssetsAutoCompressComponent',
                'enabled'                       => false,

                'readFileTimeout'               => 3,           //Time in seconds for reading each asset file

                'jsCompress'                    => true,        //Enable minification js in html code
                'jsCompressFlaggedComments'     => true,        //Cut comments during processing js

                'cssCompress'                   => true,        //Enable minification css in html code

                'cssFileCompile'                => true,        //Turning association css files
                'cssFileRemouteCompile'         => false,       //Trying to get css files to which the specified path as the remote file, skchat him to her.
                'cssFileCompress'               => true,        //Enable compression and processing before being stored in the css file
                'cssFileBottom'                 => false,       //Moving down the page css files
                'cssFileBottomLoadOnJs'         => false,       //Transfer css file down the page and uploading them using js

                'jsFileCompile'                 => true,        //Turning association js files
                'jsFileRemouteCompile'          => false,       //Trying to get a js files to which the specified path as the remote file, skchat him to her.
                'jsFileCompress'                => true,        //Enable compression and processing js before saving a file
                'jsFileCompressFlaggedComments' => true,        //Cut comments during processing js

                'htmlCompress'                  => true,        //Enable compression html
                'noIncludeJsFilesOnPjax'        => true,        //Do not connect the js files when all pjax requests
                'htmlCompressOptions'           =>              //options for compressing output result
                    [
                        'extra' => false,        //use more compact algorithm
                        'no-comments' => true   //cut all the html comments
                    ],
            ],
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
                    'levels' => ['error'],
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
                'yakassa/order-check' => 'yandexkassa/order-check',
                'yakassa/payment-aviso' => 'yandexkassa/payment-aviso',
                'xml/import' => 'xml/import',
                'site/subscribe' => 'site/subscribe',
                'mail/index' => 'mail/index',
                'favourite/add' => 'favourite/add',
                'favourite/delete' => 'favourite/delete',
                'favourite/count' => 'favourite/count',
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
                'brands/<alias>' => 'brand/view',
                'catalog/popup' => 'catalog/popup',
                'catalog/<alias>/<alias2>/<alias3>/<alias4>/<alias5>' => 'catalog/index',
                'catalog/<alias>/<alias2>/<alias3>/<alias4>' => 'catalog/index',
                'catalog/<alias>/<alias2>/<alias3>' => 'catalog/index',
                'catalog/<alias>/<alias2>' => 'catalog/index',
                'catalog/<alias>' => 'catalog/index',
                'catalog' => 'catalog/index',
                'product/<alias>' => 'catalog/view',
                '<alias>/<alias2>' => 'site/index',
                '<alias>' => 'site/index',
            ],
        ],
    ],
    'params' => $params,
];
