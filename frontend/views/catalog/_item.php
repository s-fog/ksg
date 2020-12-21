<?php

//$model -> common/models/Product

use frontend\models\Compare;
use frontend\models\Favourite;
use yii\helpers\Url;

$imageModel = $model->images[0];
$filename = explode('.', basename($imageModel->image));
$url = $model->url;
$available = $model->available;

$variants = $model->productParams;
$currentVariant = $variants[0];

if ($variants[0]->params) {
    $paramsV0 = implode('|', $variants[0]->params);
} else {
    $paramsV0 = '';
}

if (!isset($accessory)) {
    $accessory = false;
}

if (!isset($favourite)) {
    $favourite = false;
}

$inCompare = Compare::inCompare($model->id);
$inFavourite = Favourite::inFavourite($model->id);


?>
<div class="catalog__item" data-id="<?=$model->id?>">
    <div class="catalog__itemInner">
        <div class="catalog__itemTop">
            <a href="#"
               class="catalog__itemCompare js-add-to-compare"
               data-id="<?=$model->id?>"
               data-title="<?=($inCompare) ? 'Товар в сравнении' : 'Добавить в сравнение'?>">
                <span><?=($inCompare) ? 'В сравнении' : 'К сравнению'?></span>
                <svg<?=($inCompare) ? ' class="active"' : ''?> xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg></a>
        </div>
        <a href="<?=$url?>" class="catalog__itemImage">
            <img src="/images/thumbs/<?=$filename[0]?>-350-300.<?=$filename[1]?>" alt="">
        </a>
        <div class="catalog__itemPrices">
            <div class="catalog__itemAvailability">
                <?php if ($available) { ?>
                    <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.667 2.12908L4.64173 10.2351L0 5.59342L1.37924 4.21417L4.53969 7.37463L10.193 0.851608L11.667 2.12908Z" fill="#00C514"/>
                    </svg>
                    <span>В наличии</span>
                <?php } else { ?>
                    <div class="catalog__itemAvailabilityNone">x</div>
                    <span>Нет в наличии</span>
                <?php } ?>
            </div>
            <div class="catalog__itemPrice"><?=number_format($model->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
            <?php if (!empty($model->price_old)) { ?>
                <div class="catalog__itemOldPrice"><?=number_format($model->price_old, 0, '', ' ')?> <span class="rubl">₽</span></div>
            <?php } ?>
        </div>
        <a href="<?=$url?>" class="catalog__itemName"><span><?=$model->name?></span></a>
        <div class="catalog__itemFeatures">
            <?php foreach($model->getMainFeatures() as $name => $value) { ?>
                <div class="catalog__itemFeatureName"><?=$name?></div>
                <div class="catalog__itemFeatureValue"><?=$value?></div>
            <?php } ?>
        </div>
        <div class="catalog__itemBottom">
            <div data-fancybox
                 data-src="#addToCart<?=$model->id?>"
                 data-id="<?=$model->id?>"
                 data-paramsV="<?=$paramsV0?>"
                 data-quantity="1"
                 class="button2 button2_1 catalog__itemToCart">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"></path><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"></path><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"></path></g></svg>
                <span>Купить</span>
            </div>
            <div class="catalog__itemOneClick" data-fancybox="oneClick" data-src="#oneClick"><span>Купить в 1 клик</span></div>
        </div>
    </div>
</div>

