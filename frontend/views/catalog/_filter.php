<?php

use common\models\Category;

if ($model::className() == 'common/models/Category') {
    if ($model->type != 0) {
        if ($model->type == 3) {

        } else {
            $model = Category::findOne($model->parent_id);
        }
    }
}

$cookies = Yii::$app->request->cookies;

?>
<form class="filter" method="GET">
    <div class="container">
        <div class="filter__inner">
            <div class="filter__item filter__price">
                <div class="filter__priceItem">
                    <div class="filter__priceText">Цена:</div>
                </div>
                <div class="filter__priceItem">
                    <div class="filter__priceText">от</div>
                    <input type="text"
                           name="priceFrom"
                           value="<?=(isset($_GET['priceFrom']) ? $_GET['priceFrom'] : number_format($minPrice, 0, '', ' '))?>"
                           class="filter__priceInput filter__priceFrom"
                           data-minprice="<?=$minPrice?>">
                    <div class="filter__priceText"><span class="rubl">₽</span></div>
                </div>
                <div class="filter__priceItem">
                    <div class="filter__priceText">до</div>
                    <input type="text"
                           name="priceTo"
                           value="<?=(isset($_GET['priceTo']) ? $_GET['priceTo'] : number_format($maxPrice, 0, '', ' '))?>"
                           class="filter__priceInput filter__priceTo"
                           data-maxprice="<?=$maxPrice?>">
                    <div class="filter__priceText"><span class="rubl">₽</span></div>
                </div>
                <div class="filter__description filter__description_price">{Ничего не выбрано}</div>
            </div>
            <div class="filter__item filter__brands">
                <div class="filter__priceText">Бренды:</div>
                <select class="select-jquery-ui select-filter-brand" name="brand">
                    <option value="0">Все</option>
                    <?php foreach($filterBrands as $brand) { ?>
                        <?php if (isset($_GET['brand']) && $_GET['brand'] == $brand['id']) { ?>
                            <option value="<?=$brand['id']?>" selected><?=$brand['name']?></option>
                        <?php } else { ?>
                            <option value="<?=$brand['id']?>"><?=$brand['name']?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <div class="filter__description filter__brandsDescription">{Ничего не выбрано}</div>
            </div>
            <div class="filter__item filter__sort">
                <div class="filter__sort">
                    <div class="filter__priceText">Сортировать:</div>
                    <select name="sort" class="select-jquery-ui">
                        <?php if (($model::className() == 'common\models\Brand') ||
                            ($model::className() == 'common\models\Category' && ($model->level === 3 || in_array($model->type, [1, 2, 3, 4])))) { ?>
                            <option value="popular_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'popular_desc') ? ' selected' : ''?>>
                                по популярности</option>
                            <option value="price_asc"<?=((isset($_GET['sort']) && $_GET['sort'] == 'price_asc') || !isset($_GET['sort'])) ? ' selected' : ''?>>
                                сначала дешевле</option>
                            <option value="price_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? ' selected' : ''?>>
                                сначала дороже</option>
                        <?php } else { ?>
                            <option value="popular_desc"<?=((isset($_GET['sort']) && $_GET['sort'] == 'popular_desc') || !isset($_GET['sort'])) ? ' selected' : ''?>>
                                по популярности</option>
                            <option value="price_asc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? ' selected' : ''?>>
                                сначала дешевле</option>
                            <option value="price_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? ' selected' : ''?>>
                                сначала дороже</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <?php if (!empty($model->filterFeatures)) {
            $featuresActive = strstr($_SERVER['REQUEST_URI'], '&feature');
            ?>
            <div class="filter__item filter__features<?=$featuresActive ? ' active' : ''?>">
                <div class="filter__itemTop">
                    <div class="filter__header filter__itemHeader"><em class="filter__headerMinus"></em><span>Характеристики</span></div>
                    <div class="filter__description">{Ничего не выбрано}</div>
                </div>
                <div class="filter__itemInner"<?=$featuresActive ? ' style="display: block;"' : ''?>>
                    <div class="filter__itemCategoriesContents">
                        <div class="filter__itemCategoriesContent active">
                            <?php foreach($model->filterFeatures as $index => $filterFeature) {
                                $active = '';
                                if ($index == 0) $active = ' active';
                                ?>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span><?=$filterFeature->name?></span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <?php foreach($filterFeature->filterFeatureValues as $filterFeatureValue) { ?>
                                            <label class="filter__itemCategoriesContentListItem">
                                                <input type="checkbox"
                                                       name="feature<?=$filterFeature->id?>_<?=$filterFeatureValue->id?>"
                                                    <?=(isset($_GET["feature{$filterFeature->id}_{$filterFeatureValue->id}"])) ? ' checked': ''?>
                                                       value="1">
                                                <span><?=$filterFeatureValue->name?></span>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="filter__bottom">
            <button type="submit" class="button button1 filter__submit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"></polygon></g></g></svg>
                <span>применить фильтр</span>
            </button>
            <?php /*<div class="filter__filterOff js-filter-clear"><em class="filter__filterClose"></em><span>сбросить фильтр</span></div> <?php */ ?>
        </div>
    </div>
</form>