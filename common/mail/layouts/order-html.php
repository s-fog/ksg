<?php
use common\models\ProductParam;
use frontend\models\Yandexkassa;
use yii\helpers\Url;

$order = $this->params['order'];
$products = $this->params['products'];

$orderUrl = 'cart/success/'.$order->md5Id;
$host = 'https://www.ksg.ru';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html style="margin: 0 auto;width: 600px;">
<head>
    <meta name="viewport" content="width=600, initial scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Информация</title>
</head>
<body style="margin: 0 auto;width: 600px;padding: 0;font-family: Arial, sans-serif;font-size: 16px;">
<div id="mailsub">
    <div class="header" style="padding: 10px 20px;background-color: #353a49;">
        <table class="header__table">
            <tr>
                <td class="header__1" style="width: 10%;vertical-align: middle;text-align: center;"><a href="<?=$host?>/" style="font-size: 16px;color: #fff;"><img src="<?=$host?>/img/mail/logo.jpg" alt=""></a></td>
                <td class="header__2" style="width: 25%;vertical-align: middle;text-align: center;"><a href="<?=$host?>/catalog" style="font-size: 16px;color: #fff;"><img src="<?=$host?>/img/mail/catalog.jpg" alt=""></a></td>
                <td class="header__3" style="width: 25%;vertical-align: middle;text-align: center;"><a href="mailto:magazin@ksg.ru" style="font-size: 16px;color: #fff;">magazin@ksg.ru</a></td>
                <td class="header__4" style="width: 25%;vertical-align: middle;text-align: center;"><a href="tel:+74950157017" style="font-size: 16px;color: #fff;">+7 (495) 015-70-17</a></td>
            </tr>
        </table>
    </div>
    <?=$content?>
    <div class="main" style="padding: 1px 20px;background-color: #f0f2f7;">
        <div class="main__item" style="margin: 40px 0;color: #1f232f;">
            <div class="main__header" style="font-weight: bold;font-size: 18px;color: #686c7a;">Состав заказа №<a href="<?=$host?>/<?=$orderUrl?>" target="_blank" style="color: #686c7a;"><?=$order->id?></a></div>
            <table class="main__table" style="width: 100%;">
                <?php
                $i = 1;

                foreach($products as $product) {
                    $paramsV = $product->paramsV;
                    $variant = ProductParam::findOne(['product_id' => $product->id, 'params' => $paramsV]);
                    $quantity = $product->getQuantity();
                    $url = $host.$product->url;
                    ?>
                    <tr>
                        <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                            <div class="main__tableArtikul" style="margin-bottom: 3px;padding-left: 18px;font-size: 11px;">Артикул: <?=$variant->artikul?></div>
                            <div class="main__tableProduct"><?=$i?>. <a href="<?=$url?>" target="_blank" style="color: #1f232f;"><?=$product->name?></a></div>
                        </td>
                        <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;"><?=$quantity?> шт. <span style="color: #e8394a;">/</span> <?=number_format($product->price, 0, '', ' ')?> руб.</td>
                    </tr>
                <?php
                    $i++;
                    $buildCost = $product->build_cost;

                    if ($buildCost !== false && $buildCost !== NULL) {
                ?>
                        <tr>
                            <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                                <div class="main__tableProduct"><?=$i?>. Сборка "<?=$product->name?>"</div>
                            </td>
                            <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;">
                                <?=$quantity?> шт. <span style="color: #e8394a;">/</span>
                                <?=($buildCost != 0) ? ' '.number_format($buildCost, 0, '', ' ').' руб.' : ' Бесплатно'?>
                            </td>
                        </tr>
                <?php
                        $i++;
                    }
                    $warantyCost = $product->waranty_cost;

                    if ($warantyCost !== false && $warantyCost !== NULL) {
                ?>
                        <tr>
                            <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                                <div class="main__tableProduct"><?=$i?>. Гарантия на "<?=$product->name?>"</div>
                            </td>

                            <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;">
                                <?=$quantity?> шт. <span style="color: #e8394a;">/</span>
                                <?=($warantyCost != 0) ? ' '.number_format($warantyCost, 0, '', ' ').' руб.' : ' Бесплатно'?>
                            </td>
                        </tr>
                <?php
                        $i++;
                    }
                }
                ?>

                <?php foreach($products as $product) {
                    if (!empty($product->present_artikul)) {
                        $present = $product->getPresent($product->present_artikul);

                        if ($present) { ?>
                            <tr>
                                <td>+ ПОДАРОК "<a href="<?=$host.$product->url?>" style="color: #000;"><?=$present->name?></a>" 1 шт.</td>
                            </tr>
                        <?php }
                    }
                } ?>

                <?php if (!empty($order->present_artikul)) {
                    if ($present = ProductParam::findOne(['artikul' => $order->present_artikul])) {
                        if ($presentProduct = $present->product) { ?>
                            <tr>
                                <td>+ ПОДАРОК "<a href="<?=$host.$product->url?>" style="color: #000;"><?=$presentProduct->name?></a>" 1 шт.</td>
                            </tr>
                        <?php }
                    }
                } ?>
            </table>
        </div>
        <div class="main__item" style="margin: 40px 0;color: #1f232f;">
            <div class="main__header" style="font-weight: bold;font-size: 18px;color: #686c7a;">Параметры доставки</div>
            <table class="main__table" style="width: 100%;">
                <tr>
                    <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                        <div class="main__tableProduct">Стоимость</div>
                    </td>
                    <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;">
                        <?=($order->delivery_cost > 0)? "{$order->delivery_cost} руб." : "Согласно тарифам ТК"?>
                    </td>
                </tr>
                <tr>
                    <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                        <div class="main__tableProduct">Получатель</div>
                    </td>
                    <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;"><?=$order->name?></td>
                </tr>
                <tr>
                    <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                        <div class="main__tableProduct">Адрес</div>
                    </td>
                    <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;"><?=(!empty($order->address) ? $order->address : '<span class="lightRedColor">Не заполнено</span>')?></td>
                </tr>
                <tr>
                    <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                        <div class="main__tableProduct">E-mail</div>
                    </td>
                    <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;"><?=(!empty($order->email) ? $order->email : '<span class="lightRedColor">Не заполнено</span>')?></td>
                </tr>
                <tr>
                    <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                        <div class="main__tableProduct">Телефон</div>
                    </td>
                    <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;"><?=$order->phone?></td>
                </tr>
            </table>
        </div>
        <div class="main__item" style="margin-bottom: 0;margin: 40px 0;color: #1f232f;">
            <div class="main__header" style="font-weight: bold;font-size: 18px;color: #686c7a;">Сумма к оплате (руб.): <?=number_format($order->costWithDiscount(), 0, '', ' ')?></div>
            <table class="main__table" style="width: 100%;">
                <?php if (!empty($order->discount)) { ?>
                    <tr>
                        <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                            <div class="main__tableProduct">Общая сумма без скидки</div>
                        </td>
                        <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;">
                            <?=number_format($order->totalCost(), 0, '', ' ')?> руб.
                        </td>
                    </tr>
                    <tr>
                        <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                            <div class="main__tableProduct">Скидка</div>
                        </td>
                        <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;">
                            <?php if (strpos($order->discount, '%')) { ?>
                                <?=$order->discount?>
                            <?php } else { ?>
                                <?=number_format((int) $order->discount, 0, '', ' ')?> руб.
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                <tr>
                    <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                        <div class="main__tableProduct">Статус оплаты</div>
                    </td>
                    <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;">
                        <?=($order->paid == 1) ? '<span style="color: #95c11f">Оплачен</span>' : '<span style="color: #e8394a">Не оплачен</span>'?>
                    </td>
                </tr>
                <?php if ($order->paid != 1) {
                    $payUrl = "{$host}/{$orderUrl}?pay=1";
                    ?>
                    <tr>
                        <td class="main__tableName" style="vertical-align: top;text-align: left;padding: 10px 0;">
                            <div class="main__tableProduct">Вы можете <a href="<?=$payUrl?>" target="_blank" style="color: #1f232f;">оплатить онлайн</a></div>
                        </td>
                        <td class="main__tableValue" style="font-size: 14px;text-align: right;padding: 10px 0;">
                            <a href="<?=$payUrl?>" class="main__tablePayImageLink">
                                <img src="<?=$host?>/img/mail/pay.png" alt="" class="main__tablePayImage">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="woman">
            <table class="woman__table">
                <tr>
                    <td class="woman__table1" style="padding: 10px 0;vertical-align: middle;text-align: left;">
                        <img src="<?=$host?>/img/mail/woman.png" alt="" class="woman__image">
                    </td>
                    <td class="woman__table2" style="padding: 10px 0;vertical-align: middle;text-align: left;padding-left: 40px !important;">
                        <span style="font-weight: bold;color: #686c7a;line-height: 1.5;">Мы всегда на связи</span>
                        <a href="tel:+78003500608" style="display: block;color: #1f232f;line-height: 1.5;text-decoration: none;">8 (800) 350 06 08</a>
                        <a href="tel:+74950157017" style="display: block;color: #1f232f;line-height: 1.5;text-decoration: none;">+7 (495) 015-70-17</a>
                        <a href="mailto:<?=Yii::$app->params['adminEmail']?>" style="display: block;color: #1f232f;line-height: 1.5;text-decoration: none;"><?=Yii::$app->params['adminEmail']?></a>
                        <a href="<?=$host?>/" style="font-size: 16px;color: #1f232f;">Перейти на сайт</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="footer" style="padding: 20px 20px;background-color: #353a49;text-align: center;">
        <a href="https://www.facebook.com/KSG-%D0%A1%D0%BF%D0%BE%D1%80%D1%82%D0%B8%D0%B2%D0%BD%D1%8B%D0%B9-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-1908512709457176/" target="_blank" class="footer__link" style="display: inline-block;margin: 0 5px;text-decoration: none;"><img src="<?=$host?>/img/mail/facebook.png" alt=""></a>
        <a href="https://vk.com/ksgru" target="_blank" class="footer__link" style="display: inline-block;margin: 0 5px;text-decoration: none;"><img src="<?=$host?>/img/mail/vk.png" alt=""></a>
        <a href="https://www.youtube.com/channel/UC2qnabldyyfflW51ngTw3Gw" target="_blank" class="footer__link" style="display: inline-block;margin: 0 5px;text-decoration: none;"><img src="<?=$host?>/img/mail/youtube.png" alt=""></a>
        <a href="https://www.instagram.com/ksgrussia/" target="_blank" class="footer__link" style="display: inline-block;margin: 0 5px;text-decoration: none;"><img src="<?=$host?>/img/mail/insta.png" alt=""></a>
    </div>
</div>
</body>
</html>