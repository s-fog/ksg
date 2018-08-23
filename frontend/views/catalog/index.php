<?php

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;
?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $model->getBreadcrumbs()])?>

<div class="filterTrigger active" style="top: auto;">
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
            <li><a href="#" class="filterTrigger__topItem breadcrumbs__item"><span>{Ничего не выбрано}</span></a></li>
        </ul>
    </div>
    <div class="filter" style="display: none;">
        <div class="filter__outer">
            <div class="container">
                <div class="filter__top js-filter-close">
                    <div class="filter__header filter__topHeader js-filter-close active"><em class="filter__headerMinus"></em><span>фильтр каталога</span></div>
                    <div class="filter__description">{по выбраным параметрам ничего не найдено}</div>
                    <div class="filter__filterOff js-filter-close"><em class="filter__filterOffMinus"></em><span>свернуть фильтр</span></div>
                </div>
                <div class="filter__item">
                    <div class="filter__itemTop">
                        <div class="filter__header filter__itemHeader"><em class="filter__headerMinus"></em><span>Категория товара</span></div>
                        <div class="filter__description">{Ничего не выбрано}</div>
                        <div class="filter__itemSearch">
                            <input type="text" name="query" autocomplete="off" class="filter__itemSearchInput" placeholder="найти в категории товара">
                            <div class="filter__itemSearchSubmit">x<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg></div>
                        </div>
                    </div>
                    <div class="filter__itemInner">
                        <div class="filter__itemCategories">
                            <div class="filter__itemCategory active"><span>Тренажёры</span></div>
                            <div class="filter__itemCategory"><span>Велоспорт</span></div>
                            <div class="filter__itemCategory"><span>Настольный теннис</span></div>
                            <div class="filter__itemCategory"><span>Единоборства</span></div>
                        </div>
                        <div class="filter__itemCategoriesContents">
                            <div class="filter__itemCategoriesContent active">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Виброплатформы</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Виброплатформы</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent"></div>
                        </div>
                    </div>
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
                                <input type="text" name="priceFrom" value="0" class="filter__priceInput filter__priceFrom">
                                <div class="filter__priceText"><span class="rubl">₽</span></div>
                            </div>
                            <div class="filter__priceSlider ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"><div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span></div>
                            <div class="filter__priceItem">
                                <div class="filter__priceText">до</div>
                                <input type="text" name="priceTo" value="10 000 000" class="filter__priceInput filter__priceTo">
                                <div class="filter__priceText"><span class="rubl">₽</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="filter__itemTop">
                        <div class="filter__header filter__itemHeader"><em class="filter__headerMinus"></em><span>Категория товара</span></div>
                        <div class="filter__description">{Ничего не выбрано}</div>
                        <div class="filter__itemSearch">
                            <input type="text" name="query" autocomplete="off" class="filter__itemSearchInput" placeholder="найти в категории товара">
                            <div class="filter__itemSearchSubmit">x<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg></div>
                        </div>
                    </div>
                    <div class="filter__itemInner">
                        <div class="filter__itemCategories">
                            <div class="filter__itemCategory active"><span>Тренажёры</span></div>
                            <div class="filter__itemCategory"><span>Велоспорт</span></div>
                            <div class="filter__itemCategory"><span>Настольный теннис</span></div>
                            <div class="filter__itemCategory"><span>Единоборства</span></div>
                        </div>
                        <div class="filter__itemCategoriesContents">
                            <div class="filter__itemCategoriesContent active">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Виброплатформы</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Виброплатформы</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent"></div>
                        </div>
                    </div>
                </div>
                <div class="filter__item">
                    <div class="filter__itemTop">
                        <div class="filter__header filter__itemHeader"><em class="filter__headerMinus"></em><span>Категория товара</span></div>
                        <div class="filter__description">{Ничего не выбрано}</div>
                        <div class="filter__itemSearch">
                            <input type="text" name="query" autocomplete="off" class="filter__itemSearchInput" placeholder="найти в категории товара">
                            <div class="filter__itemSearchSubmit">x<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg></div>
                        </div>
                    </div>
                    <div class="filter__itemInner">
                        <div class="filter__itemCategories">
                            <div class="filter__itemCategory active"><span>Тренажёры</span></div>
                            <div class="filter__itemCategory"><span>Велоспорт</span></div>
                            <div class="filter__itemCategory"><span>Настольный теннис</span></div>
                            <div class="filter__itemCategory"><span>Единоборства</span></div>
                        </div>
                        <div class="filter__itemCategoriesContents">
                            <div class="filter__itemCategoriesContent active">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Виброплатформы</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Виброплатформы</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent">
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter__itemCategoriesContentItem">
                                    <div class="filter__itemCategoriesContentHeader"><span>Кардио тренажеры</span></div>
                                    <div class="filter__itemCategoriesContentList">
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                        <label class="filter__itemCategoriesContentListItem">
                                            <input type="checkbox" name="gfgf" value="dffd">
                                            <span>Беговые дорожки</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="filter__itemCategoriesContent"></div>
                        </div>
                    </div>
                </div>
                <div class="filter__bottom">
                    <div class="filter__filterOff js-filter-close"><em class="filter__filterOffMinus"></em><span>свернуть фильтр</span></div>
                    <div class="button button1 filter__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"></polygon></g></g></svg>
                        <span>применить фильтр</span>
                    </div>
                    <div class="filter__filterOff js-filter-clear"><em class="filter__filterClose"></em><span>сбросить фильтр</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="infs">
    <div class="container">
        <h1 class="infs__header"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>
        <div class="infs__text">
        </div>
    </div>
</div>

<div class="catalog">
    <div class="container">
        <div class="catalog__inner">
            <?php foreach($products as $item) {
                echo $this->render('@frontend/views/catalog/_item', [
                    'model' => $item
                ]);
            } ?>
        </div>
    </div>
</div>