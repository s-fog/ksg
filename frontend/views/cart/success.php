<?php

use common\models\Product;
use common\models\ProductParam;
use frontend\models\Yandexkassa;
use yz\shoppingcart\ShoppingCart;

$this->params['seo_title'] = '';
$this->params['seo_description'] = '';
$this->params['seo_keywords'] = '';
$this->params['name'] = 'Заказ оформлен';

$cart = new ShoppingCart();
$someServices = false;
$array = Yii::$app->params['cities'];
$moscow = $array['Москва'];
$others = $array['Others'];
file_put_contents("{$_SERVER['DOCUMENT_ROOT']}/www/logs/jhhhh.log", $order->paid);

?>
<?php if (isset($_GET['action']) && $_GET['action'] == 'PaymentSuccess') {
    echo '<div class="header">Заказ оплачен</div>';
} else {
    echo '<div class="header">Информация о заказе</div>';
}  ?>


<?php if (isset($_GET['pay']) && $_GET['pay'] == 1) { ?>
    <div class="redirect container">Через <span class="redirect__number">5</span> секунд Вы будете перенаправлены на страницу оплаты. Не закрывайте страницу.</div>
<?php } ?>

<div class="successOrder">
    <div class="container">
        <div class="successOrder__item successOrder__item_number" style="background-image: url(/img/success_cart.svg);">
            <div class="successOrder__header"><span>Состав заказа:</span> <?=$order->id?></div>
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
                    <?php if (strlen($product->name) > 75) { ?>
                        <li>
                            <div class="successOrder__artikul">Артикул: <?=$productParam->artikul?></div>
                            <div class="successOrder__line successOrder__line_big">
                                <div class="successOrder__lineLeft successOrder__lineLeft_big"><?=$i?>. <?=$product->name?></div>
                                <div class="successOrder__lineMiddle successOrder__lineMiddle_big"></div>
                                <div class="successOrder__lineRight successOrder__lineRight_big"><?=$product->getQuantity()?> шт. <span class="lightRedColor">/</span> <?=number_format($product->price, 0, '', ' ')?> <em class="rubl">₽</em></div>
                            </div>
                        </li>
                    <?php } else {?>
                        <li>
                            <div class="successOrder__artikul">Артикул: <?=$productParam->artikul?></div>
                            <div class="successOrder__line">
                                <div class="successOrder__lineLeft"><?=$i?>. <?=$product->name?></div>
                                <div class="successOrder__lineMiddle"></div>
                                <div class="successOrder__lineRight"><?=$product->getQuantity()?> шт. <span class="lightRedColor">/</span> <?=number_format($product->price, 0, '', ' ')?> <em class="rubl">₽</em></div>
                            </div>
                        </li>
                    <?php } ?>
                <?php $i++;} ?>

                <?php foreach($products as $product) {
                    if (!empty($product->present_artikul)) {
                        $present = $product->getPresent($product->present_artikul);

                        if ($present) {
                            echo $this->render('_successPresent', [
                                'artikul' => $product->present_artikul,
                                'present' => $present,
                                'i' => $i,
                            ]);
                        }
                    }
                } ?>

                <?php
                if (!empty($order->present_artikul)) {
                    $productParam = ProductParam::findOne(['artikul' => $order->present_artikul]);
                    $artikul = $productParam->artikul;

                    if ($productParam) {
                        $productPresent = Product::findOne($productParam->product_id);

                        if ($productPresent) {
                            echo $this->render('_successPresent', [
                                'artikul' => $artikul,
                                'present' => $productPresent,
                                'i' => $i,
                            ]);
                        }
                    } ?>
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
                        <div class="successOrder__lineRight">
                            <?=($order->delivery_cost > 0)? "{$order->delivery_cost} <em class=\"rubl\">₽</em>" : "Согласно тарифам ТК"?>
                        </div>
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
        <?php $iii = 1; ?>
        <div class="successOrder__item successOrder__item_summa" style="background-image: url(/img/succsess_money.svg);">
            <div class="successOrder__header"><span>Сумма к оплате: </span> <?=number_format($order->costWithDiscount(), 0, '', ' ')?> <em class="rubl">₽</em></div>
            <ul class="successOrder__list">
                <?php if (!empty($order->discount)) { ?>
                    <li>
                        <div class="successOrder__line">
                            <div class="successOrder__lineLeft"><?=$iii?>. Общая сумма без скидки</div>
                            <div class="successOrder__lineMiddle"></div>
                            <div class="successOrder__lineRight">
                                <?=number_format($order->totalCost(), 0, '', ' ')?> <em class="rubl">₽</em>
                            </div>
                        </div>
                    </li>
                    <?php $iii++; ?>
                    <li>
                        <div class="successOrder__line">
                            <div class="successOrder__lineLeft"><?=$iii?>. Скидка</div>
                            <div class="successOrder__lineMiddle"></div>
                            <div class="successOrder__lineRight">
                                <?php if (strpos($order->discount, '%')) { ?>
                                    <?=$order->discount?>
                                <?php } else { ?>
                                    <?=number_format((int) $order->discount, 0, '', ' ')?> <em class="rubl">₽</em>
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                <?php $iii++;} ?>
                <li>
                    <div class="successOrder__line">
                        <div class="successOrder__lineLeft"><?=$iii?>. Статус оплаты</div>
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
                <?php $iii++; ?>
                <?php if ($order->paid != 1) {
                    $yandexKassa = new Yandexkassa;
                    ?>
                    <li>
                        <div class="successOrder__line successOrder__line_big">
                            <div class="successOrder__lineLeft"><?=$iii?>. Вы можете оплатить онлайн</div>
                            <div class="successOrder__lineMiddle successOrder__lineMiddle_big"></div>
                            <div class="successOrder__lineRight">
                                <?=$yandexKassa->returnForm($order)?>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<div class="successOrderBottom">
    <div class="successOrderBottom__text">Уточнить детали заказа, узнать о последних новостях и акциях<br>
        можно в наших соц сетях</div>
    <div class="socials">

        <a href="https://www.facebook.com/KSG-%D0%A1%D0%BF%D0%BE%D1%80%D1%82%D0%B8%D0%B2%D0%BD%D1%8B%D0%B9-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-1908512709457176/" class="socials__item2" target="_blank" rel="nofollow" style="background-image: url(/img/fb_icon.svg);"></a>
        <a href="https://vk.com/ksgru" class="socials__item2" target="_blank" rel="nofollow" style="background-image: url(/img/vk_icon.svg);"></a>
        <a href="https://www.youtube.com/channel/UC2qnabldyyfflW51ngTw3Gw" class="socials__item2" target="_blank" rel="nofollow" style="background-image: url(/img/youtube_icon.svg);"></a>
        <a href="https://www.instagram.com/ksgrussia/" class="socials__item2" target="_blank" rel="nofollow" style="background-image: url(/img/instagram_icon.svg);"></a>
    </div>
    <div class="successOrderBottom__bottomText">или по телефону <a href="#" style="text-decoration: none;color: inherit; cursor: default"><?=$moscow['phone']?></a></div>
</div>