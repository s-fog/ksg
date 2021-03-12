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

if ($city == 'Москва') {
    $phone = $moscow['phone'];
    $phoneLink = $moscow['phoneLink'];
} else {
    $phone = $others['phone'];
    $phoneLink = $others['phoneLink'];
}

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
                    <a href="tel:<?=$phoneLink?>" class="mainHeader__contactsItem mainHeader__contactsItem_phone">
                        <span class="mainHeader__contactsItemTop">Бесплатный звонок</span>
                        <span class="mainHeader__contactsItemBottom"><?=$phone?></span>
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
                <?=date('Y')?> – Все права защищены.
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
