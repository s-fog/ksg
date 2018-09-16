<?php

use common\models\Param;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;
?>

<?=$this->render('_product', [
    'model' => $model,
    'brand' => $brand,
    'currentVariant' => $currentVariant,
    'variants' => $variants,
    'selects' => $selects,
    'adviser' => $adviser,
    'features' => $features,
])?>

<?=$this->render('_addToCart', [
    'model' => $model,
    'brand' => $brand,
    'currentVariant' => $currentVariant,
    'variants' => $variants,
    'selects' => $selects,
    'adviser' => $adviser,
    'features' => $features,
])?>


<div class="properties">
    <div class="properties__tabs">
        <div class="properties__tab active"><span>Описание</span></div>
        <div class="properties__tab"><span>характеристики</span></div>
        <?php if (!empty($model->video)) { ?>
            <div class="properties__tab"><span>видео обзор</span></div>
        <?php } ?>
        <div class="properties__tab"><span>отзывы</span></div>
        <svg class="properties__tabUnderline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89 7.7"><defs></defs><g><polygon points="1.7 0 0 1.4 0 3 39.7 3 44.5 7.7 49.3 3 87.3 3 89 1.5 89 0 1.7 0"></polygon></g></svg>
    </div>
    <div class="properties__contents">
        <div class="properties__content properties__descr content active">
            <div class="properties__descrInner">
                <?=$model->description?>
            </div>
        </div>
        <div class="properties__content properties__features">
            <div class="properties__featuresInner">
                <?php foreach($features as $index => $item) { ?>
                    <div class="properties__feature<?=($index == 0) ? ' active' : ''?>">
                        <div class="properties__featurePlus"></div>
                        <div class="properties__featureHeader"><span><?=$item['feature']->header?></span></div>
                        <ul class="properties__featureList"<?=($index == 0) ? ' style="display: block;"' : ''?>>
                            <?php foreach($item['values'] as $values) {
                                if (strlen($values['value']) > 75) { ?>
                                    <li class="big">
                                        <div class="properties__featureName properties__featureName_big"><?=$values['name']?></div>
                                        <div class="properties__featureMiddle properties__featureMiddle_big"></div>
                                        <div class="properties__featureValue properties__featureValue_big"><?=$values['value']?></div>
                                    </li>
                                <?php } else {
                                ?>
                                <li>
                                    <div class="properties__featureName"><?=$values['name']?></div>
                                    <div class="properties__featureMiddle"></div>
                                    <div class="properties__featureValue"><?=$values['value']?></div>
                                </li>
                                <?php }
                            } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if (!empty($model->video)) { ?>
            <div class="properties__content properties__video">
                <div class="properties__videoInner">
                    <iframe src="https://www.youtube.com/embed/<?=$model->video?>?rel=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        <?php } ?>
        <div class="properties__content properties__reviews">
            <div class="properties__reviewsInner">
                <?php if ($model->activeReviews) { ?>
                    <?php foreach($model->activeReviews as $review) { ?>
                        <div class="properties__reviewsItem">
                            <div class="properties__reviewsHeader">
                                <div class="properties__reviewsName"><?=$review->name?></div>
                                <div class="properties__reviewsDate">{<?=$review->date?>}</div>
                            </div>
                            <div class="properties__reviewsText"><?=$review->text?></div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>Отзывов нет</p>
                <?php } ?>
                <form class="reviewForm">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Ваше имя" class="reviewForm__input">
                    </div>
                    <div class="form-group">
                        <textarea name="opinion" placeholder="Ваше мнение" class="reviewForm__input reviewForm__input_textarea"></textarea>
                    </div>
                    <button class="button button1 reviewForm__submit" data-fancybox data-src="#callback">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"/></g></g></svg>
                        <span>оставить свой отзыв</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="productSlider">
    <div class="container">
        <div class="header2">Аксессуары</div>
        <div class="productSlider__inner owl-carousel">
            <div class="catalog__item" data-id="1">
                <div class="catalog__itemTop">
                    <svg class="catalog__itemCart active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg>
                    <svg class="catalog__itemCompare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg>
                    <svg class="catalog__itemFavourite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg>
                </div>
                <a href="#" class="catalog__itemImage">
                    <img src="/img/item1.png" alt="">
                    <div class="catalog__itemImageShadow"></div>
                </a>
                <a href="#" class="catalog__itemMore"><span>Узнать подробнее</span></a>
                <a href="#" class="catalog__itemName"><span>Электрическая беговая дорожка BH hii fitness sport 7098</span></a>
                <div class="catalog__itemBottomAksess">
                    <div class="catalog__itemBottomAksessLeft">
                        <div class="product__oldPrice">3 000 000 <span class="rubl">₽</span></div>
                        <div class="product__price">2 000 000 <span class="rubl">₽</span></div>
                    </div>
                    <div class="catalog__itemBottomAksessRight">
                        <button class="button button222">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 34"><g><polygon points="7.07 0 0 7.07 0 34 211.93 34 219 26.93 219 0 7.07 0"/></g></svg>
                            <span>Добавить в корзину</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="catalog__item" data-id="1">
                <div class="catalog__itemTop">
                    <svg class="catalog__itemCart active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg>
                    <svg class="catalog__itemCompare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg>
                    <svg class="catalog__itemFavourite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg>
                </div>
                <a href="#" class="catalog__itemImage">
                    <img src="/img/item1.png" alt="">
                    <div class="catalog__itemImageShadow"></div>
                </a>
                <a href="#" class="catalog__itemMore"><span>Узнать подробнее</span></a>
                <a href="#" class="catalog__itemName"><span>Электрическая беговая дорожка BH hii fitness sport 7098</span></a>
                <div class="catalog__itemBottomAksess">
                    <div class="catalog__itemBottomAksessLeft">
                        <div class="product__price">2 000 000 <span class="rubl">₽</span></div>
                    </div>
                    <div class="catalog__itemBottomAksessRight">
                        <button class="button button222">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 34"><g><polygon points="7.07 0 0 7.07 0 34 211.93 34 219 26.93 219 0 7.07 0"/></g></svg>
                            <span>Добавить в корзину</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="productSlider">
    <div class="container">
        <div class="header2">похожие товары</div>
        <div class="productSlider__inner owl-carousel">
            <div class="catalog__item" data-id="1">
                <div class="catalog__itemTop">
                    <svg class="catalog__itemCart active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg>
                    <svg class="catalog__itemCompare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg>
                    <svg class="catalog__itemFavourite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg>
                </div>
                <a href="#" class="catalog__itemImage">
                    <img src="/img/item1.png" alt="">
                    <div class="catalog__itemImageShadow"></div>
                </a>
                <a href="#" class="catalog__itemMore"><span>Узнать подробнее</span></a>
                <a href="#" class="catalog__itemName"><span>Электрическая беговая дорожка BH hii fitness sport 7098</span></a>
                <div class="catalog__itemBottom">
                    <div class="catalog__itemBottomLeft">
                        <div class="catalog__itemBottomLeftTop">
                            <span class="catalog__itemOldPrice">1 999 000 <span class="rubl">₽</span></span>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="catalog__itemPrice">1 188 900 <span class="rubl">₽</span></span>
                        </div>
                        <div class="catalog__itemBottomLeftBottom" goods-id="43423gfhfgh" data-fancybox="oneClick" data-src="#oneClick"><span>купить в один клик</span></div>
                    </div>
                    <form class="catalog__itemBottomRight">
                        <button type="submit" class="button button5 catalog__itemToCart">                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"/></g></svg>                                 <span>Купить</span>                             </button>
                    </form>
                </div>
            </div>
            <div class="catalog__item" data-id="1">
                <div class="catalog__itemTop">
                    <svg class="catalog__itemCart active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg>
                    <svg class="catalog__itemCompare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg>
                    <svg class="catalog__itemFavourite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg>
                </div>
                <a href="#" class="catalog__itemImage">
                    <img src="/img/item1.png" alt="">
                    <div class="catalog__itemImageShadow"></div>
                </a>
                <a href="#" class="catalog__itemMore"><span>Узнать подробнее</span></a>
                <a href="#" class="catalog__itemName"><span>Электрическая беговая дорожка BH hii fitness sport 7098</span></a>
                <div class="catalog__itemBottom">
                    <div class="catalog__itemBottomLeft">
                        <div class="catalog__itemBottomLeftTop">
                            <span class="catalog__itemOldPrice">1 999 000 <span class="rubl">₽</span></span>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="catalog__itemPrice">1 188 900 <span class="rubl">₽</span></span>
                        </div>
                        <div class="catalog__itemBottomLeftBottom" goods-id="43423gfhfgh" data-fancybox="oneClick" data-src="#oneClick"><span>купить в один клик</span></div>
                    </div>
                    <form class="catalog__itemBottomRight">
                        <button type="submit" class="button button5 catalog__itemToCart">                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"/></g></svg>                                 <span>Купить</span>                             </button>
                    </form>
                </div>
            </div>
            <div class="catalog__item" data-id="1">
                <div class="catalog__itemTop">
                    <svg class="catalog__itemCart active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg>
                    <svg class="catalog__itemCompare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg>
                    <svg class="catalog__itemFavourite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg>
                </div>
                <a href="#" class="catalog__itemImage">
                    <img src="/img/item1.png" alt="">
                    <div class="catalog__itemImageShadow"></div>
                </a>
                <a href="#" class="catalog__itemMore"><span>Узнать подробнее</span></a>
                <a href="#" class="catalog__itemName"><span>Электрическая беговая дорожка BH hii fitness sport 7098</span></a>
                <div class="catalog__itemBottom">
                    <div class="catalog__itemBottomLeft">
                        <div class="catalog__itemBottomLeftTop">
                            <span class="catalog__itemOldPrice">1 999 000 <span class="rubl">₽</span></span>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="catalog__itemPrice">1 188 900 <span class="rubl">₽</span></span>
                        </div>
                        <div class="catalog__itemBottomLeftBottom" goods-id="43423gfhfgh" data-fancybox="oneClick" data-src="#oneClick"><span>купить в один клик</span></div>
                    </div>
                    <form class="catalog__itemBottomRight">
                        <button type="submit" class="button button5 catalog__itemToCart">                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"/></g></svg>                                 <span>Купить</span>                             </button>
                    </form>
                </div>
            </div>
            <div class="catalog__item" data-id="1">
                <div class="catalog__itemTop">
                    <svg class="catalog__itemCart active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg>
                    <svg class="catalog__itemCompare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg>
                    <svg class="catalog__itemFavourite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg>
                </div>
                <a href="#" class="catalog__itemImage">
                    <img src="/img/item1.png" alt="">
                    <div class="catalog__itemImageShadow"></div>
                </a>
                <a href="#" class="catalog__itemMore"><span>Узнать подробнее</span></a>
                <a href="#" class="catalog__itemName"><span>Электрическая беговая дорожка BH hii fitness sport 7098</span></a>
                <div class="catalog__itemBottom">
                    <div class="catalog__itemBottomLeft">
                        <div class="catalog__itemBottomLeftTop">
                            <span class="catalog__itemOldPrice">1 999 000 <span class="rubl">₽</span></span>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="catalog__itemPrice">1 188 900 <span class="rubl">₽</span></span>
                        </div>
                        <div class="catalog__itemBottomLeftBottom" goods-id="43423gfhfgh" data-fancybox="oneClick" data-src="#oneClick"><span>купить в один клик</span></div>
                    </div>
                    <form class="catalog__itemBottomRight">
                        <button type="submit" class="button button5 catalog__itemToCart">                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"/></g></svg>                                 <span>Купить</span>                             </button>
                    </form>
                </div>
            </div>
            <div class="catalog__item" data-id="1">
                <div class="catalog__itemTop">
                    <svg class="catalog__itemCart active" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg>
                    <svg class="catalog__itemCompare" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg>
                    <svg class="catalog__itemFavourite" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg>
                </div>
                <a href="#" class="catalog__itemImage">
                    <img src="/img/item1.png" alt="">
                    <div class="catalog__itemImageShadow"></div>
                </a>
                <a href="#" class="catalog__itemMore"><span>Узнать подробнее</span></a>
                <a href="#" class="catalog__itemName"><span>Электрическая беговая дорожка BH hii fitness sport 7098</span></a>
                <div class="catalog__itemBottom">
                    <div class="catalog__itemBottomLeft">
                        <div class="catalog__itemBottomLeftTop">
                            <span class="catalog__itemOldPrice">1 999 000 <span class="rubl">₽</span></span>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="catalog__itemPrice">1 188 900 <span class="rubl">₽</span></span>
                        </div>
                        <div class="catalog__itemBottomLeftBottom" data-fancybox="oneClick" data-src="#oneClick"><span>купить в один клик</span></div>
                    </div>
                    <form class="catalog__itemBottomRight">
                        <button type="submit" class="button button5 catalog__itemToCart">                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"/></g></svg>                                 <span>Купить</span>                             </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="newsBlock">
    <div class="container">
        <div class="newsBlock__header">свежие новости</div>
        <a href="#" class="newsBlock__text"><span>смотреть все новости</span></a>
        <div class="newsBlock__inner">
            <div class="newsBlock__item">
                <a href="#" class="newsBlock__itemImage" style="background-image: url(/img/news1.png);">
                    <span class="newsBlock__itemDate"><span></span>19.03.52</span>
                    <span class="newsBlock__itemRead"><span>Читать дальше</span></span>
                </a>
                <div class="newsBlock__itemInfo">
                    <a href="#" class="newsBlock__itemHeader"><span>Как правильно проводить
                        разминку в зале</span></a>
                    <div class="newsBlock__itemText">Есть 7 простых шагов, которые должен
                        знать каждый, подходяший к спрот...</div>
                </div>
            </div>
            <div class="newsBlock__item">
                <a href="#" class="newsBlock__itemImage" style="background-image: url(/img/news2.png);">
                    <span class="newsBlock__itemDate"><span></span>19.03.52</span>
                    <span class="newsBlock__itemRead"><span>Читать дальше</span></span>
                </a>
                <div class="newsBlock__itemInfo">
                    <a href="#" class="newsBlock__itemHeader"><span>Гребные тренажёры для
                        женщин? Фарс или мистика?</span></a>
                    <div class="newsBlock__itemText">Есть 7 простых шагов, которые должен
                        знать каждый, подходяший к спрот...</div>
                </div>
            </div>
            <div class="newsBlock__item">
                <a href="#" class="newsBlock__itemImage" style="background-image: url(/img/news3.png);">
                    <span class="newsBlock__itemDate"><span></span>19.03.52</span>
                    <span class="newsBlock__itemRead"><span>Читать дальше</span></span>
                </a>
                <div class="newsBlock__itemInfo">
                    <a href="#" class="newsBlock__itemHeader"><span>Здоровье VS форма, что
                        выберешь ты?</span></a>
                    <div class="newsBlock__itemText">Есть 7 простых шагов, которые должен
                        знать каждый, подходяший к спрот...</div>
                </div>
            </div>
            <div class="newsBlock__item">
                <a href="#" class="newsBlock__itemImage" style="background-image: url(/img/news4.png);">
                    <span class="newsBlock__itemDate"><span></span>19.03.52</span>
                    <span class="newsBlock__itemRead"><span>Читать дальше</span></span>
                </a>
                <div class="newsBlock__itemInfo">
                    <a href="#" class="newsBlock__itemHeader"><span>Выбираем идеальную бытылку
                        для зала</span></a>
                    <div class="newsBlock__itemText">Есть 7 простых шагов, которые должен
                        знать каждый, подходяший к спрот...</div>
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
    <div class="sliderButton productImages__arrowLeft">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.49 24.9"><g><path class="sliderButton__outer" d="M7.25,24.9h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.26,7.26,0,0,0,32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4Z"></path><path class="sliderButton__inner" d="M25.65,18.3V6.7a.82.82,0,0,0-1.1-.7l-13.9,5.8a.8.8,0,0,0,0,1.5l13.9,5.8A.89.89,0,0,0,25.65,18.3Z"></path></g></svg>
    </div>
    <div class="sliderButton productImages__arrowRight">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39.51 24.9"><g><path class="sliderButton__outer" d="M32.25,0H17.65a7.36,7.36,0,0,0-5.1,2.1L2.15,12.5a7.26,7.26,0,0,0,5.1,12.4h14.6A7.36,7.36,0,0,0,27,22.8l10.4-10.4A7.24,7.24,0,0,0,32.25,0Z"></path><path class="sliderButton__inner" d="M13.85,6.6V18.2a.78.78,0,0,0,1.1.7l13.9-5.8a.8.8,0,0,0,0-1.5L15,5.8A.83.83,0,0,0,13.85,6.6Z"></path></g></svg>
    </div>
</div>