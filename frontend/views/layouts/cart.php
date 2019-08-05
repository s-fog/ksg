<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use frontend\assets\AppAssetCart;
use frontend\models\City;

AppAssetCart::register($this);

$city = City::getCity();
$array = Yii::$app->params['cities'];
$moscow = $array['Москва'];
$others = $array['Others'];

?>
<?php $this->beginPage() ?>

<?=$this->render('_head')?>

<body>
<?php $this->beginBody() ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K9J24XL"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<div class="mainHeader">
    <div class="mainHeader__popupTriangle"></div>
    <div class="mainHeader__outer">
        <div class="container">
            <div class="mainHeader__inner">
                <a href="/" class="mainHeader__logo">
                    <img src="/img/logo.svg" alt="" class="mainHeader__logo_desktop">
                </a>
                <div class="mainHeader__cartContacts">
                    <a href="#" class="mainHeader__contactsItem mainHeader__contactsItem_address js-hovered js-triangle js-popup" data-popup="contacts">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.8 33.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M11.3,0A11.35,11.35,0,0,0,0,11.3C0,17,9.1,31,10.2,32.6a1.5,1.5,0,0,0,2.4,0c1-1.6,10.2-15.5,10.2-21.3A11.53,11.53,0,0,0,11.3,0Zm0,29.2c-3.1-5-8.5-14.3-8.5-17.9a8.5,8.5,0,0,1,17,0C19.8,14.9,14.5,24.2,11.3,29.2Z"/><path class="cls-1" d="M11.3,7.1a4.8,4.8,0,1,0,4.8,4.8A4.74,4.74,0,0,0,11.3,7.1Zm0,6.9a2.1,2.1,0,1,1,2.1-2.1A2.11,2.11,0,0,1,11.3,14Z"/></g></svg>
                        <span class="mainHeader__contactsItemBottom"><?=$city?></span>
                    </a>
                    <a href="tel:<?=$others['phoneLink']?>" class="mainHeader__contactsItem mainHeader__contactsItem_phone">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.81 20.23"><g>
                                <path d="M16.92,4.12a2.93,2.93,0,0,0,.33-1.28,2.64,2.64,0,0,0-.93-2A3.29,3.29,0,0,0,14,0a3.92,3.92,0,0,0-2,.54,2,2,0,0,0-.26.2,1.55,1.55,0,0,0,.5,2.54h0l.2-.43A1.4,1.4,0,0,1,13,2.2a1.93,1.93,0,0,1,2,0,.69.69,0,0,1,.31.59,1.57,1.57,0,0,1-.6,1.09L11.49,7A2.09,2.09,0,0,0,11,9.36h5.24a1,1,0,0,0,1-1h0a1,1,0,0,0-1-1H13.16l2.93-2.11A4.4,4.4,0,0,0,16.92,4.12Z"/>
                                <path d="M24.16,5.42V1.86A1.74,1.74,0,0,0,22.42.12h0L17.69,5.94h0A3.36,3.36,0,0,0,20.4,7.31h1.8V8.37a1,1,0,0,0,1,1h0a1,1,0,0,0,1-1V7.31h.65V5.42Zm-4.49.06,2.58-3.05V5.48Z"/>
                                <path d="M14.65,20.23H14.6a17.35,17.35,0,0,1-10.35-4.8A15.12,15.12,0,0,1,0,4.91,5.57,5.57,0,0,1,4.92,0,4.2,4.2,0,0,1,6.43,8.14a15.44,15.44,0,0,0,2.19,3.42,14.93,14.93,0,0,0,3.24,2.14A4.2,4.2,0,0,1,20,15.12C20,17.36,17,20.23,14.65,20.23ZM4.92,1.94a3.7,3.7,0,0,0-3,3A13.42,13.42,0,0,0,5.6,14.07a15.51,15.51,0,0,0,9.08,4.24c1.32,0,3.42-2,3.42-3.19a2.28,2.28,0,0,0-4.56,0,1,1,0,0,1-.44.8,1,1,0,0,1-.92.07,20.35,20.35,0,0,1-4.91-3.07,20.71,20.71,0,0,1-3.1-5.08A.94.94,0,0,1,4.24,7,1,1,0,0,1,5,6.5a2.28,2.28,0,0,0-.09-4.56Z"/></g></svg>
                        <span class="mainHeader__contactsItemBottom"><?=$others['phone']?></span>
                    </a>
                </div>
            </div>
            <div class="mainHeader__hovered"></div>
        </div>
    </div>
    <?=$this->render('_mainHeader__popup_contacts')?>
</div>


<?=$content?>

<div class="footer">
    <div class="container">
        <div class="footer__cartInner">
            <div class="footer__cartLeft">
                ООО "КейЭсДжи"<br>
                Спортивный интернет-магазин.<br>
                2018 – Все права защищены.
            </div>
            <div class="footer__cartMiddle">
                <div class="footer__cartMiddleItem">В Москве: <a href="tel:<?=$moscow['phoneLink']?>" class="linkReverse"><?=$moscow['phone']?></a></div>
                <div class="footer__cartMiddleItem">Для регионов: <a href="tel:<?=$others['phoneLink']?>" class="linkReverse"><?=$others['phone']?></a></div>
            </div>
            <div class="footer__cartRight">
                <div class="button button1 callbackButton" data-fancybox data-src="#callback">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"/></g></g></svg>
                    <span>заказать обратный звонок</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="popup productImages" id="productImages">
    <div class="productImages__inner">
        <div class="productImages__info">
            <div class="productImages__header"></div>
            <div class="productImages__text"></div>
        </div>
        <div class="productImages__image"><img src="" alt=""></div>
    </div>
    <div class="productImages__arrowLeft"><img src="/img/arrowLeft.svg"></div>
    <div class="productImages__arrowRight"><img src="/img/arrowRight.svg"></div>
</div>

<div class="popup addressMap" id="addressMap">
    <div class="addressMap__inner" id="addressMap__inner"></div>
    <div class="addressMap__topText">Двигая карту, выберите необходимую точку на карте под прицелом</div>
    <div class="addressMap__center">
        <div class="addressMap__centerMark">
            <div class="addressMap__centerMarkInner addressMap__centerMarkInner_top"></div>
            <div class="addressMap__centerMarkInner addressMap__centerMarkInner_top2"></div>
            <div class="addressMap__centerMarkInner addressMap__centerMarkInner_bottom"></div>
            <div class="addressMap__centerMarkInner addressMap__centerMarkInner_bottom2"></div>
            <div class="addressMap__centerMarkInner addressMap__centerMarkInner_left"></div>
            <div class="addressMap__centerMarkInner addressMap__centerMarkInner_left2"></div>
            <div class="addressMap__centerMarkInner addressMap__centerMarkInner_right"></div>
            <div class="addressMap__centerMarkInner addressMap__centerMarkInner_right2"></div>
        </div>
        <div class="addressMap__centerAddress"></div>
        <div class="button button7 addressMap__centerPick">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 95.76 35.29"><g><polygon points="8.44 0 0 6.99 0 35.3 87.32 35.3 95.76 28.31 95.76 0 8.44 0"/></g></svg>
            <span>Выбрать</span>
        </div>
    </div>
</div>


<?=$this->render('@frontend/views/blocks/callback')?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
