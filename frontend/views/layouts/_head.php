<?php

use yii\helpers\Html;

?>
    <!doctype html>
<html lang="ru">
<head>
    <meta charset="<?=Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <link rel="icon" type="image/svg+xml" href="/favicon.ico">
<?= Html::csrfMetaTags() ?>
    <title><?=(isset($this->params['seo_title']) && !empty($this->params['seo_title']))? $this->params['seo_title'] : $this->params['name'].' | KSG'?></title>
<?=(isset($this->params['seo_description']) && !empty($this->params['seo_description']))? '<meta name="description" content="'.$this->params['seo_description'].'">' : ''?>
<?=(isset($this->params['seo_keywords']) && !empty($this->params['seo_keywords']))? '<meta name="keywords" content="'.$this->params['seo_keywords'].'">' : ''?>
<?=(isset($this->params['canonical']) && !empty($this->params['canonical']))? '<link rel="canonical" href="'.$this->params['canonical'].'">' : ''?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K9J24XL');</script>
    <!-- End Google Tag Manager -->

<?php $this->head() ?>
    <link rel="preload" crossorigin href="/fonts/r.woff2" as="font">
    <link rel="preload" crossorigin href="/fonts/d.woff2" as="font">
    <link rel="preload" crossorigin href="/fonts/unisansheavycaps-webfont.woff2" as="font">
    <link rel="preload" crossorigin href="/fonts/Sports%20World.woff2" as="font">
    <link rel="preload" crossorigin href="/fonts/PT%20Sans.woff2" as="font">
</head>