<?php

use common\models\Category;
use common\models\Textpage;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->params['seo_title'] = $model->seo_h1;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;

$childrenCategories = $model->getChildrenCategories();

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
        <?php
            $page = (isset($_GET['page'])) ? $_GET['page'] : '1';
            $h1 = '';
            $pagePart = ($page != 1) ? ' - Страница '.$page : '';

            if (empty($model->seo_h1)) {
                $h1 = $model->name.$pagePart;
            } else {
                $h1 = $model->seo_h1.$pagePart;
            }
        ?>
        <h1 class="infs__header"><?=$h1?></h1>
        <div class="infs__text">
        </div>
    </div>
</div>

<div class="category">
    <div class="container">
        <?php if ($childrenCategories) { ?>
            <div class="category__slider owl-carousel">
                <?php foreach($childrenCategories as $childrenCategory) {
                    $filename = explode('.', basename($childrenCategory->image_menu));

                    if (empty($filename[1])) {
                        $filename[1] = '';
                    }
                    ?>
                    <a href="<?=$childrenCategory->url?>" class="category__sliderItem">
                        <span class="category__sliderItemImage" style="background-image: url(/images/thumbs/<?=$filename[0]?>-134-134.<?=$filename[1]?>);"></span>
                        <span class="category__sliderItemName"><span><?=$childrenCategory->name?></span></span>
                    </a>
                <?php } ?>
            </div>
        <?php }
        $per_page = 0;
        if (isset($_GET['per_page']))
            $per_page = $_GET['per_page'];
        ?>
        <form action="" method="get" class="sorting">
            <div class="sorting__perpage">
                <span class="sorting__text">показывать по </span>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="1"
                        <?=($per_page == 1) ? ' checked' : ''?>>
                    <span>1</span>
                </label>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="5"
                        <?=($per_page == 5) ? ' checked' : ''?>>
                    <span>5</span>
                </label>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="10"
                        <?=($per_page == 10) ? ' checked' : ''?>>
                    <span>10</span>
                </label>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="20"
                        <?=($per_page == 20 || $per_page == 0) ? ' checked' : ''?>>
                    <span>20</span>
                </label>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="40"
                        <?=($per_page == 40) ? ' checked' : ''?>>
                    <span>40</span>
                </label>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="60"
                        <?=($per_page == 60) ? ' checked' : ''?>>
                    <span>60</span>
                </label>
                <label class="sorting__label">
                    <input
                        type="radio"
                        name="per_page"
                        value="120"
                        <?=($per_page == 120) ? ' checked' : ''?>>
                    <span>120</span>
                </label>
            </div>
            <div class="sorting__delimiter">|</div>
            <div class="sorting__sort">
                <span class="sorting__text">сортировать</span>
                <select name="sort" class="select-jquery-ui">
                    <option value=""<?=(!isset($_GET['sort'])) ? ' selected' : ''?>>по популярности</option>
                    <option value="price_asc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? ' selected' : ''?>>сначала недорогие</option>
                    <option value="price_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? ' selected' : ''?>>сначала дорогие</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="catalog">
    <div class="container">
        <div class="catalog__inner">
            <?php
            $productCount = count($products);
            $serials = '<div class="advice__brands">';

            if (!empty($brandsSerial) && $model->type == 2) {
                foreach($brandsSerial as $item) {
                    $serials .= '<a href="'.$item->url.'" class="advice__brandsLink">'.$item->name.'</a>';
                }
            }

            $serials .= '</div>';

            foreach($products as $index => $item) {
                echo $this->render('@frontend/views/catalog/_item', [
                    'model' => $item
                ]);

                if (($index == 2 || (($productCount - 1) == $index && $index < 3)) && !empty($model->text_advice)) {
                    echo '<div class="catalog__item advice">
                            <div class="advice__inner">
                                <div class="advice__header">Совет от KSG</div>
                                <div class="advice__html content">
                                    '.$model->text_advice.'
                                </div>
                                '.$serials.'
                            </div>
                        </div>';
                }
            } ?>
        </div>
    </div>
</div>

<?=LinkPager::widget([
    'pagination' => $pages,
    'disableCurrentPageButton' => true,
    'hideOnSinglePage' => true,
    'maxButtonCount' => 6
]);?>

<?php if ($tags) { ?>
    <div class="category__tags">
        <div class="container">
            <?php foreach($tags as $tag) { ?>
                <a href="<?=$tag->url?>" class="category__tag"><span><?=$tag->name?></span></a>
            <?php }
            if (count($tags) > 10) {
                echo '<a href="#" class="category__tagSeeAll"><span>посмотреть все-&gt;</span></a>';
            }
            ?>
        </div>
    </div>
<?php } ?>

<?php if ($years) { ?>
    <div class="category__years">
        <div class="container">
            <span class="category__item">Год:</span>
            <?php foreach($years as $year) { ?>
                <a href="<?=$year->url?>" class="category__item link"><span><?=$year->name?></span></a>
            <?php }
            ?>
        </div>
    </div>
<?php } ?>

<div class="brands">
    <div class="container">
        <div class="brands__header"><?=$bHeader?></div>
        <div class="brands__inner owl-carousel">
            <?php foreach($productsBrands as $brand) {
                echo $this->render('@frontend/views/brand/_item', ['model' => $brand]);
            } ?>
        </div>
    </div>
    <div class="brands__list">
        <div class="textBlock">
            <div class="brands__listInner">
                <?php foreach($brands as $brand) { ?>
                    <a href="<?=$brand->url?>" class="brands__listItem"><span><?=$brand->name?></span></a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

