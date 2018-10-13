<?php
use common\models\Param;
use common\models\ProductParam;
use frontend\models\Compare;
use frontend\models\Favourite;

$inCompare = Compare::inCompare($model->id);
$inFavourite = Favourite::inFavourite($model->id);

?>
<div class="product" data-id="<?=$model->id?>">
    <div class="container">
        <div class="product__inner">
            <div class="product__topLeft">
                <?php $filename = explode('.', basename($brand->image)); ?>
                <img src="/images/thumbs/<?=$filename[0]?>-60-30.<?=$filename[1]?>" alt="<?=$model->name?>" class="product__brandImage">
                <div class="product__brand">Бренд: <a href="<?=$brand->link?>" class="link"><?=$brand->name?></a></div>
                <h1 itemprop="name"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>
                <div class="product__art">Артикул: <?=$currentVariant->artikul?>&nbsp;&nbsp;//&nbsp;&nbsp;Код товара: <?=$model->code?></div>
                <div class="product__seeAllImage">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.8 37.8"><g><path d="M18.9,0A18.9,18.9,0,1,0,37.8,18.9,18.95,18.95,0,0,0,18.9,0Zm0,35A16.1,16.1,0,1,1,35,18.9,16.09,16.09,0,0,1,18.9,35Z"/><path d="M29.8,10H19.3V8a1.37,1.37,0,0,0-1.4-1.4H11A1.37,1.37,0,0,0,9.6,8v2H8.1a1.37,1.37,0,0,0-1.4,1.4V27a1.37,1.37,0,0,0,1.4,1.4H29.9A1.37,1.37,0,0,0,31.3,27V11.4A1.52,1.52,0,0,0,29.8,10ZM12.4,9.5h4.1V10H12.4Zm16,16.1H9.5V12.8H28.4Z"/><path d="M14.1,19.2A4.8,4.8,0,0,0,18.9,24a4.87,4.87,0,0,0,4.8-4.8,4.8,4.8,0,0,0-4.8-4.8A4.87,4.87,0,0,0,14.1,19.2Zm4.8-2a2,2,0,1,1-2,2A2,2,0,0,1,18.9,17.2Z"/><path d="M24.2,16.1h2.4a1.4,1.4,0,0,0,0-2.8H24.2a1.4,1.4,0,1,0,0,2.8Z"/></g></svg>
                    <span>смотреть все фото</span>
                </div>
                <?php if (!empty($model->instruction)) { ?>
                    <a href="<?=$model->instruction?>" target="_blank" class="product__seeInstruction">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.8 37.8"><g><path d="M18.9,0A18.9,18.9,0,1,0,37.8,18.9,18.95,18.95,0,0,0,18.9,0Zm0,35A16.1,16.1,0,1,1,35,18.9,16.09,16.09,0,0,1,18.9,35Z"/><path d="M14.8,14H29.2a1.4,1.4,0,1,0,0-2.8H14.8a1.4,1.4,0,0,0,0,2.8Z"/><path d="M29.2,17.5H14.8a1.4,1.4,0,1,0,0,2.8H29.2a1.37,1.37,0,0,0,1.4-1.4A1.43,1.43,0,0,0,29.2,17.5Z"/><path d="M29.2,23.9H14.8a1.4,1.4,0,0,0,0,2.8H29.2a1.37,1.37,0,0,0,1.4-1.4A1.43,1.43,0,0,0,29.2,23.9Z"/><path d="M10.7,11.1H9.3a1.4,1.4,0,0,0,0,2.8h1.4a1.4,1.4,0,0,0,0-2.8Z"/><path d="M10.7,17.5H9.3a1.4,1.4,0,1,0,0,2.8h1.4a1.4,1.4,0,1,0,0-2.8Z"/><path d="M10.7,23.9H9.3a1.4,1.4,0,1,0,0,2.8h1.4a1.4,1.4,0,0,0,0-2.8Z"/></g></svg>
                        <span>смотреть инструкцию</span>
                    </a>
                <?php } ?>
            </div>
            <div class="product__images">
                <?php
                $image0 = $model->images[$currentVariant->image_number];
                $filename = explode('.', basename($image0->image)); ?>
                <div class="product__mainImage js-product-image"
                     data-paramsv="<?=($currentVariant->params) ? implode('|', $currentVariant->params) : ''?>"
                     data-header="<?=$model->name?>"
                     data-text="<?=$image0->text?>"
                     data-image="/images/thumbs/<?=$filename[0]?>-770-553.<?=$filename[1]?>"
                     data-fancybox="productImages"
                     data-src="#productImages">
                    <img src="/images/thumbs/<?=$filename[0]?>-770-553.<?=$filename[1]?>" alt="<?=$model->name?>" itemprop="image">
                </div>
                <?php foreach($model->images as $index => $imageModel) {
                    if ($index != $currentVariant->image_number) {
                        $filename = explode('.', basename($imageModel->image));
                        $var = ProductParam::findOne(['product_id' => $model->id, 'image_number' => $index]);
                        ?>
                        <div class="product__otherImage js-product-image"
                             data-paramsv="<?=($var) ? implode('|', $var->params) : ''?>"
                             data-header="<?=$model->name?>"
                             data-text="<?=$imageModel->text?>"
                             data-image="/images/thumbs/<?=$filename[0]?>-770-553.<?=$filename[1]?>"
                             data-fancybox="productImages"
                             data-src="#productImages"></div>
                    <?php }
                } ?>
                <div class="product__allPhoto">смотреть все фото</div>
            </div>
            <form class="product__topRight">
                <div class="catalog__itemTop">
                    <a href="#"
                       class="catalog__itemCart js-add-to-cart"
                       data-id="<?=$model->id?>"
                       data-paramsV="<?=($currentVariant->params) ? implode('|', $currentVariant->params) : ''?>"
                       data-quantity="1"
                       title="Добавить в корзину"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg></a>
                    <a href="#"
                       class="catalog__itemFavourite js-add-to-favourite"
                       data-id="<?=$model->id?>"
                       title="<?=($inFavourite) ? 'Товар в избранном' : 'Добавить в избранное'?>">
                        <svg<?=($inFavourite) ? ' class="active"' : ''?> xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg></a>
                    <a href="#"
                       class="catalog__itemCompare js-add-to-compare"
                       data-id="<?=$model->id?>"
                       title="<?=($inCompare) ? 'Товар в сравнении' : 'Добавить в сравнение'?>">
                        <svg<?=($inCompare) ? ' class="active"' : ''?> xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg></a>
                </div>
                <div class="product__req">
                    <?php
                    $empty = true;
                    foreach($variants as $variant) {
                        if ($variant->available > 0) {
                            $empty = false;
                        }
                    } ?>

                    <?php if ($empty) { ?>
                        <div class="product__available">
                            <span>Нет в наличии</span>
                        </div>
                    <?php } else { ?>
                        <div class="product__available active">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 23.1"><g><polygon points="16.1 0 13.6 1 6.8 17.9 2.8 12.7 0.3 12.4 0 15 6.3 23.1 8.6 23.1 17 2.4 16.1 0"/></g></svg>
                            <span>Есть в наличии</span>
                        </div>
                    <?php } ?>
                    &nbsp;/&nbsp;
                    <?php if (!$empty) { ?>
                        <div class="product__requestSale" data-fancybox="oneClick" data-src="#oneClick">Купить в один клик</div>
                    <?php } ?>
                </div>
                <div class="product__toCart" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <div class="product__toCartLeft">
                        <?php if (!empty($model->price_old)) { ?>
                            <div class="product__oldPrice"><?=number_format($model->price_old, 0, '', ' ')?> <span class="rubl">₽</span></div>
                        <?php } ?>
                        <div class="product__price"><?=number_format($model->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
                        <span itemprop="price" style="display: none;"><?=$model->price?></span>
                    </div>
                    <span style="display: none;" itemprop="priceCurrency">RUB</span>
                    <?php if (!$empty) { ?>
                        <?php if (!empty($selects)) { ?>
                            <div class="product__toCartRight">
                                <button class="button button5 catalog__itemToCart" data-fancybox data-src="#addToCart">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"></polygon></g></svg>
                                    <span>Купить</span>
                                </button>
                            </div>
                        <?php } else { ?>
                            <div class="product__toCartRight">
                                <button class="button button5 catalog__itemToCart" data-fancybox data-src="#addToCart"
                                        data-id="<?=$model->id?>"
                                        data-quantity="1"
                                        data-paramsv="">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"></polygon></g></svg>
                                    <span>Купить</span>
                                </button>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <!--<div class="product__toCart" data-fancybox data-src="#addToCart"><span>купить за 200 000 <em class="rubl">₽</em></span></div>
                <div class="product__count cart__countInner">
                    <div class="cart__countMinus"></div>
                    <input type="text" name="count" class="cart__countInput" value="1">
                    <div class="cart__countPlus"></div>
                </div>
                <div class="product__toCart" data-fancybox data-src="#addToCartNoParams"><span>купить за 200 000 <em class="rubl">₽</em></span></div>
                <input type="hidden" name="id" value="1">
                <div class="product__buyOneClick" data-fancybox="oneClick" data-src="#oneClick"><span>купить в один клик</span></div>-->
                <div class="product__selects">
                    <?php foreach($selects as $name => $values) {
                        $param = Param::findOne(['name' => $name]);
                        ?>
                        <div class="product__select">
                            <span class="product__selectName"><?=$name?>:</span>
                            <div></div>
                            <select name="<?=$param->name_en?>" class="select-product-jquery-ui select-<?=$param->name_en?>-jquery-ui">
                                <?php foreach($values as $value) {?>
                                    <option
                                        <?=($value['active']) ? 'selected' : ''?>
                                        value="<?=$value['value']?>"><?=$value['value']?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
            </form>
            <?php if ($adviser) { ?>
                <div class="product__bottomLeft">
                    <?php $filename = explode('.', basename($adviser->image)); ?>
                    <img src="/images/thumbs/<?=$filename[0]?>-130-175.<?=$filename[1]?>" alt="" class="product__adviceImage">
                    <div class="product__adviceHeader"><?=$adviser->header?></div>
                    <div class="product__adviceText"><?=$model->adviser_text?></div>
                </div>
            <?php } ?>
            <div class="product__bottomRight">
                <div class="product__features">
                    <div class="product__featureItem">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54.2 54.2"><g id="Слой_1-2" data-name="Слой 1"><circle class="cls-1" cx="27.1" cy="27.1" r="27.1"/><path class="cls-2" d="M49.4,42.5c-2.4-4-8.8-7-17-7.9.8-.4,1.6-.9,2.4-1.4A10.31,10.31,0,0,0,44.9,22.9a17.8,17.8,0,0,0-35.6,0,1.4,1.4,0,0,0,2.8,0,15,15,0,0,1,30,0A7.68,7.68,0,0,1,38,29.6a12.5,12.5,0,0,0,1.9-6.7A12.8,12.8,0,1,0,21.8,34.6c-8.2.9-14.6,3.9-17,7.9.6.8,1.2,1.6,1.9,2.4C8,40.9,15.8,37,27.1,37s19.2,3.9,20.4,7.9C48.2,44.1,48.8,43.3,49.4,42.5ZM27.1,33a10.21,10.21,0,1,1,6.7-2.6,7.12,7.12,0,0,1-4.1-1.7,3,3,0,0,0,.2-1A2.9,2.9,0,1,0,27,30.6a1.27,1.27,0,0,0,.6-.1,8.8,8.8,0,0,0,2.9,1.8A9.37,9.37,0,0,1,27.1,33Z"/></g></svg>
                        <span>Проверенные и опытные
консультанты на связи 24/7</span>
                    </div>
                    <div class="product__featureItem">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54.2 54.2"><defs><style>.left3g{fill:none;}.left3gf{fill:#a6a8ae;}.left3gff{fill:#fff;}</style></defs><title>icon5</title><g id="Слой_2" data-name="Слой 2"><g id="Слой_1-2" data-name="Слой 1"><path class="left3g" d="M4.1,41.5a26.31,26.31,0,0,1-2.9-6.1A6.75,6.75,0,0,0,1,36.8,5.18,5.18,0,0,0,4.1,41.5Z"/><path class="left3gf" d="M17.9,20.1a1.4,1.4,0,1,1,0,2.8H.3A27.28,27.28,0,0,0,0,27a29.86,29.86,0,0,0,.4,4.3A7.87,7.87,0,0,1,14,35.2H28.6a7.93,7.93,0,0,1,15.6,0h.9V25.9l-5.8-3.1H22.8a1.56,1.56,0,0,1-1.3-.8l-3.2-6.1v-.1c0-.1-.1-.2-.1-.3s-.1-.2-.1-.3v-.3a.37.37,0,0,1,.1-.3.35.35,0,0,1,.1-.2.35.35,0,0,1,.1-.2l.2-.2a.1.1,0,0,0,.1-.1h.1c.1,0,.2-.1.3-.1s.2-.1.3-.1H33.7L33,12.5H4A26.56,26.56,0,0,0,.8,19.8H17.9Zm5.6,4.7h4.6a1.4,1.4,0,0,1,0,2.8H23.5a1.37,1.37,0,0,1-1.4-1.4A1.31,1.31,0,0,1,23.5,24.8Z"/><polygon class="left3gf" points="21.9 16.9 23.6 20.1 37 20.1 35.2 16.9 21.9 16.9"/><path class="left3gf" d="M6.3,36.8a.1.1,0,0,0-.2,0C6,36.9,6.3,36.9,6.3,36.8Z"/><path class="left3gf" d="M27.1,0a26.87,26.87,0,0,0-21,10H33.9a1.39,1.39,0,0,1,1.2.7l5.2,9.6,6.8,3.6a1.34,1.34,0,0,1,.8,1.3V36.8a1.37,1.37,0,0,1-1.4,1.4H44.2a7.93,7.93,0,0,1-15.6,0H14a8,8,0,0,1-7.5,6.5A27.1,27.1,0,1,0,27.1,0Z"/><path class="left3gf" d="M36.5,36.8a.1.1,0,0,0-.1-.1l-.1.1C36.2,36.9,36.5,36.9,36.5,36.8Z"/><path class="left3gf" d="M36.4,41.9a5.1,5.1,0,1,0-5.1-5.1A5,5,0,0,0,36.4,41.9Zm0-8.1a3,3,0,0,1,0,6,3,3,0,1,1,0-6Z"/><path class="left3gf" d="M6.2,41.9a5.1,5.1,0,1,0,0-10.2,5.16,5.16,0,0,0-4.9,3.7,26.31,26.31,0,0,0,2.9,6.1A5.92,5.92,0,0,0,6.2,41.9Zm0-8.1a3,3,0,0,1,0,6,3,3,0,0,1,0-6Z"/><path class="left3gff" d="M6.2,39.7a3,3,0,0,0,0-6,3,3,0,0,0,0,6Zm0-3a.1.1,0,0,1,.1.1c0,.1-.2.1-.2,0S6.1,36.7,6.2,36.7Z"/><path class="left3gff" d="M36.4,39.7a3,3,0,0,0,0-6,3,3,0,1,0,0,6Zm0-3a.1.1,0,0,1,.1.1c0,.1-.2.1-.2,0S36.3,36.7,36.4,36.7Z"/><path class="left3gff" d="M14,38.2H28.6a7.93,7.93,0,0,0,15.6,0h2.3a1.37,1.37,0,0,0,1.4-1.4V25.2a1.56,1.56,0,0,0-.8-1.3l-6.8-3.6-5.2-9.6a1.21,1.21,0,0,0-1.2-.7H6.1c-.7.9-1.4,1.9-2,2.8h29l.7,1.2H19.5a.37.37,0,0,0-.3.1.37.37,0,0,0-.3.1h-.1a.1.1,0,0,0-.1.1c-.1.1-.2.1-.2.2s-.1.1-.1.2a.35.35,0,0,1-.1.2.37.37,0,0,1-.1.3v.3a.37.37,0,0,0,.1.3.37.37,0,0,0,.1.3v.1l3.2,6.1a1.34,1.34,0,0,0,1.3.8H39.4l5.8,3.1v9.3h-.9a7.93,7.93,0,0,0-15.6,0H14.1A7.94,7.94,0,0,0,6.3,29,7.71,7.71,0,0,0,.5,31.6a25.85,25.85,0,0,0,.9,4,5.16,5.16,0,0,1,4.9-3.7,5.1,5.1,0,0,1,0,10.2,6.47,6.47,0,0,1-2-.4,24.28,24.28,0,0,0,2.4,3.2A8.5,8.5,0,0,0,14,38.2Zm9.6-18.1-1.7-3.2H35.3l1.8,3.2ZM36.4,31.7a5.1,5.1,0,1,1-5.1,5.1A5,5,0,0,1,36.4,31.7Z"/><path class="left3gff" d="M19.3,21.6a1.37,1.37,0,0,0-1.4-1.4H.9C.7,21.1.5,22.1.3,23H17.9A1.43,1.43,0,0,0,19.3,21.6Z"/><path class="left3gff" d="M23.5,27.6h4.6a1.4,1.4,0,0,0,0-2.8H23.5a1.37,1.37,0,0,0-1.4,1.4A1.31,1.31,0,0,0,23.5,27.6Z"/></g></g></svg>
                        <span>Бесплатная доставка при заказе от 7 900  р.</span>
                    </div>
                    <div class="product__featureItem">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54.2 54.2"><g id="Слой_1-2" data-name="Слой 1"><circle class="cls-1" cx="27.1" cy="27.1" r="27.1"/><path class="cls-2" d="M27.9,27.5a1.39,1.39,0,0,0-1.9,0,1.3,1.3,0,0,0,0,1.9l11,11a1.22,1.22,0,0,0,.9.4,1.09,1.09,0,0,0,.9-.4,1.39,1.39,0,0,0,0-1.9Z"/><path class="cls-2" d="M37.2,30.1a11.5,11.5,0,0,0,6.9-3.3,11.72,11.72,0,0,0,3.2-10.4,1.17,1.17,0,0,0-.9-1,1.44,1.44,0,0,0-1.3.3L39,21.8l-4.9-1.3-1.3-4.9,6.1-6.1a1.21,1.21,0,0,0,.3-1.3,1.17,1.17,0,0,0-1-.9,11.45,11.45,0,0,0-10.4,3.2A11.61,11.61,0,0,0,24.9,22l-1.2,1.2-7.3-7.3a.1.1,0,0,1-.1-.1,1.36,1.36,0,0,0,0-1.5L12.6,8.8a1.7,1.7,0,0,0-1-.6,1.5,1.5,0,0,0-1.1.4L7.2,11.9A1.5,1.5,0,0,0,6.8,13a1.33,1.33,0,0,0,.6,1L13,17.6a1.85,1.85,0,0,0,.7.2,1.42,1.42,0,0,0,.6-.2.1.1,0,0,0,.1.1L21.7,25,7.9,38.8a1.39,1.39,0,0,0,0,1.9l5.9,5.9a1.22,1.22,0,0,0,.9.4,1.09,1.09,0,0,0,.9-.4L26.1,36.1,35,45a5.78,5.78,0,0,0,4,1.7A5.61,5.61,0,0,0,43,45l.4-.4h0a5.61,5.61,0,0,0,1.7-4,5.44,5.44,0,0,0-1.7-4ZM10.3,12.7l1-1,2,2.9Zm19.2-.3a8.79,8.79,0,0,1,5.2-2.5l-4.5,4.5a1.21,1.21,0,0,0-.3,1.3l1.7,6.4a1.18,1.18,0,0,0,.9.9l6.4,1.7a1.52,1.52,0,0,0,1.3-.3l4.5-4.5a8.52,8.52,0,0,1-2.5,5.2,8.7,8.7,0,0,1-7.4,2.5h-.2L28,21a1.14,1.14,0,0,0-.8-.3A9,9,0,0,1,29.5,12.4ZM14.8,43.8l-4-4,9.6-9.6,4,4Zm26.9-1.1-.4.4a3.14,3.14,0,0,1-4.4,0L22.3,28.5,27,23.8,41.6,38.4a3.1,3.1,0,0,1,.9,2.2A2.93,2.93,0,0,1,41.7,42.7Z"/></g></svg>
                        <span>При необходимости, соберём и обучим пользоваться</span>
                    </div>
                    <div class="product__featureItem">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54.2 54.2"><g id="Слой_1-2" data-name="Слой 1"><circle class="cls-1" cx="27.1" cy="27.1" r="27.1"/><path class="cls-2" d="M43.7,44.5,37.6,30.3a1.79,1.79,0,0,0,.7-.5,3.07,3.07,0,0,0,.5-3.9.45.45,0,0,1,0-.5.52.52,0,0,1,.4-.2h.1a3.21,3.21,0,0,0,3.1-2.4,3.17,3.17,0,0,0-1.6-3.7.54.54,0,0,1-.3-.4.37.37,0,0,1,.3-.4,3.37,3.37,0,0,0,1.6-3.7,3.21,3.21,0,0,0-3.1-2.4h-.1a.7.7,0,0,1-.4-.2.45.45,0,0,1,0-.5,3.19,3.19,0,0,0-.5-4,3.19,3.19,0,0,0-4-.5.45.45,0,0,1-.5,0,.52.52,0,0,1-.2-.4,3.22,3.22,0,0,0-2.4-3.2A3.17,3.17,0,0,0,27.5,5h0a.54.54,0,0,1-.4.3.37.37,0,0,1-.4-.3A3.37,3.37,0,0,0,23,3.4a3.22,3.22,0,0,0-2.4,3.2.43.43,0,0,1-.2.4.45.45,0,0,1-.5,0,3.19,3.19,0,0,0-4,.5,3.19,3.19,0,0,0-.5,4,.45.45,0,0,1,0,.5.52.52,0,0,1-.4.2h-.1a3.21,3.21,0,0,0-3.1,2.4,3.17,3.17,0,0,0,1.6,3.7.54.54,0,0,1,.3.4.37.37,0,0,1-.3.4,3.37,3.37,0,0,0-1.6,3.7,3.21,3.21,0,0,0,3.1,2.4H15a.31.31,0,0,1,.4.2.45.45,0,0,1,0,.5,3.19,3.19,0,0,0,.5,4c.2.2.4.3.6.5l-6,14.3a1.4,1.4,0,0,0,.2,1.4,1.3,1.3,0,0,0,1.3.5l6.6-1.3,3.6,5.6a1.38,1.38,0,0,0,1.1.6h.1a1.33,1.33,0,0,0,1.1-.8l2.3-5.5,2.5,5.5a1.17,1.17,0,0,0,1.1.8h.1a1.15,1.15,0,0,0,1.1-.6l3.6-5.6,6.6,1.3a1.3,1.3,0,0,0,1.3-.5C43.8,45.5,43.9,45,43.7,44.5ZM14.9,22.3c-.3,0-.4-.2-.5-.4a.73.73,0,0,1,.2-.6,3.42,3.42,0,0,0,1.7-2.8,3,3,0,0,0-1.7-2.8c-.3-.2-.3-.4-.2-.6s.2-.3.5-.4a3.36,3.36,0,0,0,2.9-1.6,3.25,3.25,0,0,0,0-3.3c-.2-.3-.1-.5.1-.6a.56.56,0,0,1,.6-.1,3.25,3.25,0,0,0,3.3,0,3.36,3.36,0,0,0,1.6-2.9c0-.3.2-.4.4-.5a.73.73,0,0,1,.6.2,3.42,3.42,0,0,0,2.8,1.7h0A3,3,0,0,0,30,5.9c.2-.3.4-.3.6-.2a.46.46,0,0,1,.4.5,3.36,3.36,0,0,0,1.6,2.9,3.25,3.25,0,0,0,3.3,0c.3-.2.5-.1.6.1a.61.61,0,0,1,.1.6,3.25,3.25,0,0,0,0,3.3,3.36,3.36,0,0,0,2.9,1.6c.3,0,.4.2.5.4a.73.73,0,0,1-.2.6,3.42,3.42,0,0,0-1.7,2.8,3,3,0,0,0,1.7,2.8c.3.2.3.4.2.6a.46.46,0,0,1-.5.4,3.36,3.36,0,0,0-2.9,1.6,3.25,3.25,0,0,0,0,3.3c.2.3.1.5-.1.6a.56.56,0,0,1-.6.1,3.25,3.25,0,0,0-3.3,0A3.36,3.36,0,0,0,31,30.8c0,.3-.2.4-.4.5a.73.73,0,0,1-.6-.2,3.42,3.42,0,0,0-2.8-1.7h0a3,3,0,0,0-2.8,1.7c-.2.3-.4.3-.6.2a.46.46,0,0,1-.4-.5,3.36,3.36,0,0,0-1.6-2.9,3.25,3.25,0,0,0-3.3,0,.43.43,0,0,1-.6-.1.56.56,0,0,1-.1-.6,3.25,3.25,0,0,0,0-3.3A3.36,3.36,0,0,0,14.9,22.3ZM23.2,47l-2.7-4.2a1.34,1.34,0,0,0-1.4-.6l-4.9,1,5.4-12.7c.1-.1.3-.1.4-.2a.45.45,0,0,1,.5,0,.52.52,0,0,1,.2.4,3.49,3.49,0,0,0,1,2.4l3.9,8.5Zm12-4.8a1.28,1.28,0,0,0-1.4.6L31,47.1,24.9,33.8a3.53,3.53,0,0,0,1.7-1.5A.54.54,0,0,1,27,32h0a.37.37,0,0,1,.4.3A3.09,3.09,0,0,0,30.2,34a2.77,2.77,0,0,0,.9-.1,3.22,3.22,0,0,0,2.4-3.2.43.43,0,0,1,.2-.4.45.45,0,0,1,.5,0c.1.1.2.1.4.2v.2L40,43.3Z"/><path class="cls-2" d="M26.9,26.5A7.9,7.9,0,1,0,19,18.6,7.85,7.85,0,0,0,26.9,26.5Zm0-13.1a5.2,5.2,0,1,1-5.2,5.2A5.23,5.23,0,0,1,26.9,13.4Z"/></g></svg>
                        <span>Гарантия производителя
и доп. гарантия от KSG</span>
                    </div>
                    <div class="product__featureItem">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 54.2 54.2"><g id="Слой_1-2" data-name="Слой 1"><circle class="cls-1" cx="27.1" cy="27.1" r="27.1"/><path class="cls-2" d="M31.3,25.2V14.9c2.6,1,4.4,2.7,4.4,4.7a1.5,1.5,0,0,0,3,0c0-3.6-3-6.6-7.4-7.9V4.6a1.5,1.5,0,1,0-3,0v6.6H25.2V4.6a1.5,1.5,0,0,0-3,0v6.9c-3.4.7-6.8,2.5-6.8,8.1s3.4,7.4,6.8,8.1V38c-2.3-1-3.8-2.6-3.8-4.5a1.5,1.5,0,0,0-3,0c0,3.5,2.7,6.4,6.8,7.7V49a1.5,1.5,0,0,0,3,0V41.9A10.87,10.87,0,0,0,27,42h1.3v7a1.5,1.5,0,0,0,3,0V41.8c4-.4,7.4-2,7.4-8.3S35.3,25.7,31.3,25.2Zm-4.2-11a6.15,6.15,0,0,1,1.3.1V25.1H25.3V14.3A9.72,9.72,0,0,1,27.1,14.2Zm-8.7,5.4c0-2.8,1-4.3,3.8-5v10C19.5,24,18.4,22.4,18.4,19.6ZM27.1,39a10.87,10.87,0,0,1-1.8-.1V28.1h3.1V39A5.63,5.63,0,0,0,27.1,39Zm4.2-.2V28.2c3.1.3,4.4,1.5,4.4,5.3S34.4,38.5,31.3,38.8Z"/></g></svg>
                        <span>Поможем в оформлении
кредита и рассрочки</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
