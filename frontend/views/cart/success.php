<?php

use common\models\Product;
use common\models\ProductParam;
use yz\shoppingcart\ShoppingCart;

$this->params['seo_title'] = '';
$this->params['seo_description'] = '';
$this->params['seo_keywords'] = '';
$this->params['name'] = 'Заказ оформлен';

$cart = new ShoppingCart();
$someServices = false;

?>
<div class="header">Заказ оформлен</div>
<div class="successOrder">
    <div class="container">
        <div class="successOrder__item successOrder__item_number" style="background-image: url(/img/success_cart.svg);">
            <div class="successOrder__header"><span>Состав заказа:</span> 10000<?=$order->id?></div>
            <ul class="successOrder__list">
                <?php
                $products = unserialize(base64_decode($order->products));
                $i = 1;

                foreach($products as $md5Id => $product) {
                    $productParam = ProductParam::find()->where([
                        'product_id' => $product->id,
                        'params' => $product->paramsV,
                    ])->one();

                    if ($product->build_cost !== NULL && $product->build_cost !== false && $product->build_cost >= 0) {
                        $someServices = true;
                    }

                    if ($product->waranty_cost !== NULL && $product->waranty_cost !== false && $product->waranty_cost >= 0) {
                        $someServices = true;
                    }
                ?>
                    <li>
                        <div class="successOrder__artikul">Артикул: <?=$productParam->artikul?></div>
                        <div class="successOrder__line">
                            <div class="successOrder__lineLeft"><?=$i?>. <?=$product->name?></div>
                            <div class="successOrder__lineMiddle"></div>
                            <div class="successOrder__lineRight"><?=$product->getQuantity()?> шт. <span class="lightRedColor">/</span> <?=number_format($product->price, 0, '', ' ')?> <em class="rubl">₽</em></div>
                        </div>
                    </li>
                <?php $i++;} ?>

                <?php
                if (!empty($order->present_artikul)) {
                    $productParam = ProductParam::findOne(['artikul' => $order->present_artikul]);
                    $productPresent = Product::findOne($productParam->product_id);

                    if ($productPresent) {
                    ?>
                        <li>
                            <div class="successOrder__artikul">Артикул: <?=$productParam->artikul?></div>
                            <div class="successOrder__line successOrder__line_big">
                                <div class="successOrder__lineLeft successOrder__lineLeft_big"><?=$i?>. <?=$productPresent->name?></div>
                                <div class="successOrder__lineMiddle successOrder__lineMiddle_big"></div>
                                <div class="successOrder__lineRight">
                                    <div class="cart__price">
                                        <div class="cart__presentImage"></div>
                                        <div class="cart__oldPrice"><?=number_format($product->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
                                        <div class="cart__presentText">подарок от KSG</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
        <?php if ($someServices) { ?>
            <div class="successOrder__item successOrder__item_delivery" style="background-image: url(/img/services.svg);">
                <div class="successOrder__header"><span>Услуги</span></div>
                <ul class="successOrder__list">
                    <?php
                    $i = 1;
                    foreach($products as $md5Id => $product) {
                        if ($product->build_cost === 0 || $product->build_cost > 0) { ?>
                            <li>
                                <div class="successOrder__line">
                                    <div class="successOrder__lineLeft"><?=$i?>. Сборка <?=$product->name?></div>
                                    <div class="successOrder__lineMiddle"></div>
                                    <div class="successOrder__lineRight">
                                        <?=($product->build_cost > 0) ?
                                            $product->getQuantity().' шт. <span class="lightRedColor">/</span> '.number_format($product->build_cost, 0, "", " ").' <em class="rubl">₽</em> = '.number_format($product->build_cost * $product->getQuantity(), 0, "", " "). ' <em class="rubl">₽</em>'
                                            :
                                            $product->getQuantity().' шт. <span class="greenColor" style="font-weight: bold;">Бесплатно</span>'?>
                                    </div>
                                </div>
                            </li>
                    <?php    $i++;}
                        if ($product->waranty_cost === 0 || $product->waranty_cost > 0) { ?>
                            <li>
                                <div class="successOrder__line">
                                    <div class="successOrder__lineLeft"><?=$i?>. Гарантия <?=$product->name?></div>
                                    <div class="successOrder__lineMiddle"></div>
                                    <div class="successOrder__lineRight">
                                        <?=($product->waranty_cost > 0) ?
                                            $product->getQuantity().' шт. <span class="lightRedColor">/</span> '.number_format($product->waranty_cost, 0, "", " ").' <em class="rubl">₽</em> = '.number_format($product->waranty_cost * $product->getQuantity(), 0, "", " "). ' <em class="rubl">₽</em>'
                                            :
                                            $product->getQuantity().' шт. <span class="greenColor" style="font-weight: bold;">Бесплатно</span>'?>
                                    </div>
                                </div>
                            </li>
                        <?php $i++;}
                    }
                    ?>

                </ul>
            </div>
        <?php } ?>
        <div class="successOrder__item successOrder__item_delivery" style="background-image: url(/img/succsess_auto.svg);">
            <div class="successOrder__header"><span>Параметры доставки</span></div>
            <ul class="successOrder__list">
                <li>
                    <div class="successOrder__line">
                        <div class="successOrder__lineLeft">1. Стоимость</div>
                        <div class="successOrder__lineMiddle"></div>
                        <div class="successOrder__lineRight">Согласно тарифам ТК</div>
                    </div>
                </li>
                <li>
                    <div class="successOrder__line">
                        <div class="successOrder__lineLeft">2. Получатель</div>
                        <div class="successOrder__lineMiddle"></div>
                        <div class="successOrder__lineRight"><?=$order->name?></div>
                    </div>
                </li>
                <?php
                if (strlen($order->address) > 75) { ?>
                    <li>
                        <div class="successOrder__line successOrder__line_big">
                            <div class="successOrder__lineLeft">3. Адрес</div>
                            <div class="successOrder__lineMiddle successOrder__lineMiddle_big"></div>
                            <div class="successOrder__lineRight successOrder__lineRight_big"><?=$order->address?></div>
                        </div>
                    </li>
                <?php } else {
                ?>
                    <li>
                        <div class="successOrder__line">
                            <div class="successOrder__lineLeft">3. Адрес</div>
                            <div class="successOrder__lineMiddle"></div>
                            <div class="successOrder__lineRight"><?=(!empty($order->address) ? $order->address : '<span class="lightRedColor">Не заполнено</span>')?></div>
                        </div>
                    </li>
                <?php } ?>
                <li>
                    <div class="successOrder__line">
                        <div class="successOrder__lineLeft">4. Телефон</div>
                        <div class="successOrder__lineMiddle"></div>
                        <div class="successOrder__lineRight"><?=$order->phone?></div>
                    </div>
                </li>
                <li>
                    <div class="successOrder__line">
                        <div class="successOrder__lineLeft">5. E-mail</div>
                        <div class="successOrder__lineMiddle"></div>
                        <div class="successOrder__lineRight"><?=(!empty($order->email) ? $order->email : '<span class="lightRedColor">Не заполнено</span>')?></div>
                    </div>
                </li>
            </ul>
        </div>
        <?php
        $serviceCost = 0;

        foreach($products as $product) {
            $quantity = $product->getQuantity();

            if ($product->build_cost > 0) {
                $serviceCost += $product->build_cost * $quantity;
            }

            if ($product->waranty_cost > 0) {
                $serviceCost += $product->waranty_cost * $quantity;
            }
        }
        ?>
        <div class="successOrder__item successOrder__item_summa" style="background-image: url(/img/succsess_money.svg);">
            <div class="successOrder__header"><span>Сумма к оплате: </span> <?=number_format($order->total_cost + $serviceCost, 0, '', ' ')?> <em class="rubl">₽</em></div>
            <ul class="successOrder__list">
                <li>
                    <div class="successOrder__line">
                        <div class="successOrder__lineLeft">1. Статус оплаты</div>
                        <div class="successOrder__lineMiddle"></div>
                        <div class="successOrder__lineRight">
                            <?php if ($order->paid == 0) {
                                echo '<span class="lightRedColor">Не оплачено</span>';
                            } else if ($order->paid == 1) {
                                echo '<span class="greenColor">Оплачено</span>';
                            } ?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="successOrderBottom">
    <div class="successOrderBottom__text">Уточнить детали заказа, узнать о последних новостях и акциях<br>
        можно в наших соц сетях</div>
    <div class="socials">
        <a href="#" class="socials__item2" target="_blank" rel="nofollow" style="background-image: url(/img/fb_icon.svg);"></a>
        <a href="#" class="socials__item2" target="_blank" rel="nofollow" style="background-image: url(/img/vk_icon.svg);"></a>
        <a href="#" class="socials__item2" target="_blank" rel="nofollow" style="background-image: url(/img/youtube_icon.svg);"></a>
        <a href="#" class="socials__item2" target="_blank" rel="nofollow" style="background-image: url(/img/instagram_icon.svg);"></a>
    </div>
    <div class="successOrderBottom__bottomText">или по телефону +7 123 123 23 23</div>
</div>