<?php

use common\models\Category;

if ($model::className() == 'common/models/Category') {
    if ($model->type != 0) {
        if (!$model->type == 3) {
            $model = Category::findOne($model->parent_id);
        }
    }
}

$url = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$urlWithoutPath = $url['scheme'].'://'.$url['host'].$url['path'];

?>

<form class="filter<?=isset($_COOKIE['set_filter_opened']) && $_COOKIE['set_filter_opened'] == 76 ? ' active' : ''?>"
    <?=!empty($model->filter_url) ? 'data-filter-url="'.$urlWithoutPath.'"' : '' ?>
    data-parent-url="<?=($model::className() === 'common\models\Category') ? $model->getParentCategory()->url : ''?>"
>
    <div class="filter__mobileOpen<?=isset($_COOKIE['set_filter_opened']) && $_COOKIE['set_filter_opened'] == 76 ? ' active' : ''?>">
        <span class="filter__mobileOpenText">Фильтр</span>
        <span class="filter__mobileOpenIcon"></span>
    </div>
    <div class="filter__inner">
        <div class="filter__item">
            <div class="filter__itemHeader">Цена</div>
            <div class="filter__itemContent filter__itemContent_prices">
                <div class="form-group">
                    <input type="text"
                           name="priceFrom"
                           <?=(isset($get['priceFrom']) ? 'value="'.$get['priceFrom'].'"' : '')?>
                           class="filter__priceInput filter__priceFrom"
                           placeholder="от <?=number_format($minPrice, 0, '', ' ')?> р"
                           data-maxprice="<?=$maxPrice?>"
                           data-minprice="<?=$minPrice?>">
                </div>
                <div class="form-group">
                    <input type="text"
                           name="priceTo"
                           <?=(isset($get['priceTo']) ? 'value="'.$get['priceTo'].'"' : '')?>
                           class="filter__priceInput filter__priceTo"
                           placeholder="до <?=number_format($maxPrice, 0, '', ' ')?> р"
                           data-minprice="<?=$minPrice?>"
                           data-maxprice="<?=$maxPrice?>">
                </div>
            </div>
        </div>
        <div class="filter__item">
            <div class="filter__itemHeader">Бренды</div>
            <div class="filter__itemContent">
                <?php
                $i = 0;

                foreach($filterBrands as $brand) {
                    $checked = false;

                    if (isset($get['brands']) && in_array($brand['id'], $get['brands'])) {
                        $checked = true;
                    }
                    ?>
                    <label class="filter__itemLabel<?=$i > 4 ? ' filter__itemLabel_hidden' : ''?>">
                        <input type="checkbox"
                               name="brands[]"
                            <?=$checked ? 'checked' : ''?>
                               value="<?= $brand['id'] ?>">
                        <span><?= $brand['name'] ?></span>
                    </label>

                    <?php
                    if ($i == 4) { ?>
                        <div class="filter__showMore">Показать все</div>
                    <?php }
                    $i++;
                } ?>
            </div>
        </div>
        <?php foreach($filterFeatures as $index => $filterFeature) {?>
            <div class="filter__item">
                <div class="filter__itemHeader"><?=$filterFeature['name']?></div>
                <div class="filter__itemContent">
                    <?php
                    $i = 0;
                    foreach($filterFeature['filterFeatureValues'] as $filterFeatureValue) { ?>
                        <label class="filter__itemLabel<?=$i > 4 ? ' filter__itemLabel_hidden' : ''?>">
                            <input type="checkbox"
                                   name="feature<?=$filterFeature['id']?>_<?=$filterFeatureValue['id']?>"
                                   <?=(isset($get["feature{$filterFeature['id']}_{$filterFeatureValue['id']}"])) ? ' checked': ''?>
                                   value="1">
                            <span><?=$filterFeatureValue['name']?></span>
                        </label>
                        <?php
                        if ($i == 4) { ?>
                            <div class="filter__showMore">Показать все</div>
                        <?php }
                    $i++;
                    } ?>
                </div>
            </div>
        <?php } ?>
        <button type="submit" class="button button1 filter__submit js-filter-submit">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"></polygon></g></g></svg>
            <span>Применить фильтр</span>
        </button>
        <button type="submit" class="filter__fixedSubmit js-filter-submit">
            <span>Применить</span>
        </button>
    </div>
</form>