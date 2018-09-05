<?php

use common\models\Image;
use common\models\ProductParam;

$variant = ProductParam::findOne(['product_id' => $product->id, 'params' => $product->paramsV]);
$image = Image::find()
    ->where(['product_id' => $product->id])
    ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
    ->offset($variant->image_number)
    ->one();
$filename = explode('.', basename($image->image));
$quantity = $product->getQuantity();
?>

<tr class="cart__row" data-id="<?=$product->getId()?>">
    <td>
        <div class="cart__item">
            <a href="#" target="_blank" class="cart__itemImage">
                <img src="/images/thumbs/<?=$filename[0]?>-350-300.<?=$filename[1]?>" alt="">
            </a>
            <div class="cart__itemInfo">
                <div class="cart__itemArtikul">Артикуль: <?=$variant->artikul?></div>
                <a href="#" target="_blank" class="cart__itemName"><span><?=$product->name?></span></a>
            </div>
        </div>
    </td>
    <td>
        <div class="cart__price">
            <div class="cart__priceValue"><?=number_format($product->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
        </div>
    </td>
    <td>
        <div class="cart__count">
            <div class="cart__countInner">
                <div class="cart__countMinus"></div>
                <input type="text" name="count" class="cart__countInput" value="<?=$quantity?>" data-id="<?=$product->id?>">
                <div class="cart__countPlus"></div>
            </div>
        </div>
    </td>
</tr>