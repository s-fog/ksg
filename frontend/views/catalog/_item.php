<?php

//$model -> common/models/Product

use common\models\Image;
use common\models\ProductParam;
use yii\helpers\Url;

$imageModel = $model->images[0];
$filename = explode('.', basename($imageModel->image));
$url = Url::to(['catalog/view', 'alias' => $model->alias]);
$variants = ProductParam::find()->where(['product_id' => $model->id])->orderBy(['id' => SORT_ASC])->all();
$available = $model->available;
var_dump($available);

if ($variants[0]->params) {
    $paramsV0 = implode('|', $variants[0]->params);
} else {
    $paramsV0 = '';
}

if (!isset($accessory)) {
    $accessory = false;
}


?>
<div class="catalog__item" data-id="<?=$model->id?>">
    <div class="catalog__itemTop">
        <a href="#"
           class="catalog__itemCart js-add-to-cart"
           data-id="<?=$model->id?>"
           data-paramsV="<?=$paramsV0?>"
           data-quantity="1"
           title="Добавить в корзину"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg></a>
        <a href="#"
           class="catalog__itemFavourite js-add-to-favourite"
           data-id="<?=$model->id?>"
           title="Добавить в избранное"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg></a>
        <a href="#"
           class="catalog__itemCompare js-add-to-compare"
           data-id="<?=$model->id?>"
           title="Добавить в сравнение"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg></a>
    </div>
    <a href="<?=$url?>" class="catalog__itemImage">
        <img src="/images/thumbs/<?=$filename[0]?>-350-300.<?=$filename[1]?>" alt="">
        <span class="catalog__itemImageShadow"></span>
    </a>
    <a href="<?=$url?>" class="catalog__itemMore"><span>Узнать подробнее</span></a>
    <a href="<?=$url?>" class="catalog__itemName"><span><?=$model->name?></span></a>
    <?php if ($accessory) { ?>
        <div class="catalog__itemBottomAksess">
            <div class="catalog__itemBottomAksessLeft">
                <?php if (!empty($model->price_old)) { ?>
                    <div class="product__oldPrice"><?=number_format($model->price_old, 0, '', ' ')?> <span class="rubl">₽</span></div>
                <?php } ?>
                <div class="product__price"><?=number_format($model->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
            </div>
            <div class="catalog__itemBottomAksessRight">
                <button class="button button222 js-add-to-cart"
                        data-id="<?=$model->id?>"
                        data-paramsV="<?=$paramsV0?>"
                        data-quantity="1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 34"><g><polygon points="7.07 0 0 7.07 0 34 211.93 34 219 26.93 219 0 7.07 0"></polygon></g></svg>
                    <span>Добавить в корзину</span>
                </button>
            </div>
        </div>
    <?php } else { ?>
        <div class="catalog__itemBottom">
            <div class="catalog__itemBottomLeft">
                <div class="catalog__itemBottomLeftTop">
                    <?php if (!empty($model->price_old)) { ?>
                        <span class="catalog__itemOldPrice"><?=number_format($model->price_old, 0, '', ' ')?> <span class="rubl">₽</span></span>
                        &nbsp;&nbsp;/&nbsp;&nbsp;
                        <span class="catalog__itemPrice"><?=number_format($model->price, 0, '', ' ')?> <span class="rubl">₽</span></span>
                    <?php } else { ?>
                        <span class="catalog__itemPrice"><?=number_format($model->price, 0, '', ' ')?> <span class="rubl">₽</span></span>
                    <?php } ?>
                </div>
                <?php if ($available) { ?>
                    <div class="catalog__itemBottomLeftBottom" data-fancybox="oneClick" data-src="#oneClick"><span>купить в один клик</span></div>
                <?php } ?>
            </div>
            <?php if ($available) { ?>
                <div class="catalog__itemBottomRight">
                    <div type="submit"
                         data-id="<?=$model->id?>"
                         data-paramsV="<?=$paramsV0?>"
                         data-quantity="1"
                         class="button button5 js-add-to-cart catalog__itemToCart">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"/></g></svg>
                        <span>Купить</span>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if (!$available) { ?>
            <div class="catalog__itemName catalog__itemNotAvailable">Товара нет в наличии</div>
        <?php } ?>
    <?php } ?>
</div>