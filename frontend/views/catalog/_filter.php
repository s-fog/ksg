<div class="filterTrigger active">
    <div class="container">
        <ul class="filterTrigger__top breadcrumbs__inner">
            <li>
                <a href="#" class="filterTrigger__topItem js-filter-open breadcrumbs__item">
                    <em class="filterTrigger__openPlus"></em>
                    <span>Фильтр</span>
                    <span class="filterTrigger__topItemCount">{по выбраным параметрам ничего не найдено}</span>
                </a>
            </li>
            <li><a href="#" class="filterTrigger__topItem breadcrumbs__item"><span>{Ничего не выбрано}</span></a></li>
            <li><a href="#" class="filterTrigger__topItem breadcrumbs__item"><span>{Ничего не выбрано}</span></a></li>
            <li><a href="#" class="filterTrigger__topItem breadcrumbs__item"><span>{Ничего не выбрано}</span></a></li>
        </ul>
    </div>
    <form class="filter" method="GET" style="display: none;">
        <div class="filter__outer">
            <div class="container">
                <div class="filter__top js-filter-close">
                    <div class="filter__filterOff js-filter-close"><em class="filter__filterOffMinus"></em><span>свернуть фильтр</span></div>
                </div>
                <div class="filter__item">
                    <div class="filter__itemTop">
                        <div class="filter__header filter__itemHeader"><em class="filter__headerMinus"></em><span>Цена</span></div>
                        <div class="filter__description filter__description_price">{Ничего не выбрано}</div>
                    </div>
                    <div class="filter__itemInner">
                        <div class="filter__price">
                            <div class="filter__priceItem">
                                <div class="filter__priceText">от</div>
                                <input type="text"
                                       name="priceFrom"
                                       value="<?=(isset($_GET['priceFrom']) ? $_GET['priceFrom'] : number_format($minPrice, 0, '', ' '))?>"
                                       class="filter__priceInput filter__priceFrom"
                                       data-minprice="<?=$minPrice?>">
                                <div class="filter__priceText"><span class="rubl">₽</span></div>
                            </div>
                            <div class="filter__priceSlider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"><div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span></div>
                            <div class="filter__priceItem">
                                <div class="filter__priceText">до</div>
                                <input type="text"
                                       name="priceTo"
                                       value="<?=(isset($_GET['priceTo']) ? $_GET['priceTo'] : number_format($maxPrice, 0, '', ' '))?>"
                                       class="filter__priceInput filter__priceTo"
                                       data-maxprice="<?=$maxPrice?>">
                                <div class="filter__priceText"><span class="rubl">₽</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="filter__itemTop">
                        <div class="filter__header filter__itemHeader"><em class="filter__headerMinus"></em><span>Бренды</span></div>
                        <div class="filter__description">{Ничего не выбрано}</div>
                        <div class="filter__itemSearch">
                            <input type="text" name="query" value="" autocomplete="off" class="filter__itemSearchInput" placeholder="найти в брендах">
                            <div class="filter__itemSearchSubmit">x<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg></div>
                        </div>
                    </div>
                    <div class="filter__itemInner">
                        <div class="filter__itemCategoriesContents">
                            <div class="filter__itemCategoriesContent active">
                                <?php
                                $countBrands = count($filterBrands);
                                $elementsInColumn = (int) ceil($countBrands / 4);

                                foreach($filterBrands as $index => $brand) {
                                    if ($index == 0) {
                                        echo '<div class="filter__itemCategoriesContentItem">
                                        <div class="filter__itemCategoriesContentList">';
                                    }

                                    echo '<label class="filter__itemCategoriesContentListItem">
                                          <input type="checkbox" 
                                          name="brand_'.$brand["id"].'"
                                          '.((isset($_GET["brand_{$brand['id']}"])) ? ' checked' : '').'
                                          value="1">
                                          <span>'.$brand["name"].'</span>
                                    </label>';

                                    if (($index + 1) % $elementsInColumn == 0) {
                                        echo '</div></div>
                                    <div class="filter__itemCategoriesContentItem">
                                        <div class="filter__itemCategoriesContentList">';
                                    }

                                    if (($index + 1) == $countBrands) {
                                        echo '</div></div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="filter__itemTop">
                        <div class="filter__header filter__itemHeader"><em class="filter__headerMinus"></em><span>Характеристики</span></div>
                        <div class="filter__description">{Ничего не выбрано}</div>
                        <div class="filter__itemSearch">
                            <input type="text" name="query" value="" autocomplete="off" class="filter__itemSearchInput" placeholder="найти в характеристиках">
                            <div class="filter__itemSearchSubmit">x<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg></div>
                        </div>
                    </div>
                    <div class="filter__itemInner">
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
                <div class="filter__bottom">
                    <div class="filter__filterOff js-filter-close"><em class="filter__filterOffMinus"></em><span>свернуть фильтр</span></div>
                    <button type="submit" class="button button1 filter__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"></polygon></g></g></svg>
                        <span>применить фильтр</span>
                    </button>
                    <div class="filter__filterOff js-filter-clear"><em class="filter__filterClose"></em><span>сбросить фильтр</span></div>
                </div>
            </div>
        </div>
    </form>
</div>
