<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->params['seo_title'] = '404 - страница не найдена';
$this->params['seo_description'] = '';
$this->params['seo_keywords'] = '';
$this->params['name'] = '404';

?>
<div class="notFound">
    <a href="/" class="notFound__logo"><img src="/img/logo_mobile.svg" alt=""></a>
    <div class="notFound__inner">
        <div class="notFound__image"></div>
        <div class="notFound__text">УПС, ЧТО-ТО ПОШЛО НЕ ТАК...<br>
            ТАКОЙ СТРАНИЦЫ НЕ СУЩЕСТВУЕТ</div>
        <a href="/" class="button button4 notFound__toMain">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 34"><g><polygon class="cls-1" points="108.93 0 14.43 0 8.13 0 0 6.73 0 34 14.49 34 109 34 131.87 34 140 27.27 140 0 108.93 0"></polygon></g></svg>
            <span>на главную</span>
        </a>
        <a href="/catalog" class="notFound__toCatalog"><span>в каталог</span></a>
    </div>
</div>
