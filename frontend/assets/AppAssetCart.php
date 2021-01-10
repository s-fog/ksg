<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAssetCart extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/vendor/jquery-ui/themes/base/base.css',
        'js/vendor/owl.carousel/dist/assets/owl.carousel.min.css',
        'js/vendor/fancybox/dist/jquery.fancybox.min.css',
        'css/jquery.kladr.min.css',
        'css/styles.css',
    ];
    public $js = [
        'https://api-maps.yandex.ru/2.1/?lang=ru_RU',
        'js/vendor.js',
        'js/flex-grid-add-elements.js',
        'js/jquery.kladr.min.js',
        'js/bodyScrollLock.min.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
