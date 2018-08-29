<?php

use common\models\Category;
use common\models\Textpage;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_h1;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;

$childrenCategories = $model->getChildrenCategories();

?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => [[0] => 'Корзина']])?>

<form class="cart">
    <h1 class="header">Корзина</h1>
    <div class="cart__block">
        <div class="cart__inner">
            <table class="cart__table">
                <tr>
                    <th>Наименование</th>
                    <th>Цена</th>
                    <th>Количество</th>
                </tr>
                <tr>
                    <td>
                        <div class="cart__item">
                            <a href="#" target="_blank" class="cart__itemImage">
                                <img src="/img/cartProduct.png" alt="">
                            </a>
                            <div class="cart__itemInfo">
                                <div class="cart__itemArtikul">Артикуль: NETL20716</div>
                                <a href="#" target="_blank" class="cart__itemName"><span>Бутылка для воды ы ы ы ы</span></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="cart__price">
                            <div class="cart__presentImage"></div>
                            <div class="cart__oldPrice"> 1 900 <span class="rubl">₽</span></div>
                            <div class="cart__presentText">подарок от KSG</div>
                        </div>
                    </td>
                    <td>
                        <div class="cart__count">
                            <div class="cart__countInner">
                                <input type="text" name="count" class="cart__countInput" value="1" readonly>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="cart__item">
                            <a href="#" target="_blank" class="cart__itemImage">
                                <img src="/img/cartProduct.png" alt="">
                            </a>
                            <div class="cart__itemInfo">
                                <div class="cart__itemArtikul">Артикуль: NETL20716</div>
                                <a href="#" target="_blank" class="cart__itemName"><span>Бутылка для воды ы ы ы ы</span></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="cart__price">
                            <div class="cart__priceValue">1 900 000 <span class="rubl">₽</span></div>
                        </div>
                    </td>
                    <td>
                        <div class="cart__count">
                            <div class="cart__countInner">
                                <div class="cart__countMinus"></div>
                                <input type="text" name="count" class="cart__countInput" value="1">
                                <div class="cart__countPlus"></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br><br>
    <div class="cart__block">
        <div class="cart__inner">
            <div class="cart__header"><span>Сборка</span></div>
            <div class="cart__blockItem">
                <div class="cart__blockItemLeft" style="background-image: url(/img/construct.png);"></div>
                <div class="cart__blockItemRight">
                    <div class="cart__blockItemHeader">Сборка специалистами KSG</div>
                    <div class="cart__blockItemText">tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.</div>
                    <div class="checkbox">
                        <div class="checkbox__inner">
                            <label class="checkbox__item">
                                <input type="radio" name="construct" value="0" checked>
                                <span>Спасибо, не надо</span>
                            </label>
                            <label class="checkbox__item">
                                <input type="radio" name="construct" value="1">
                                <span>Добавить за 1 900 <em class="rubl">₽</em></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart__block">
        <div class="cart__inner">
            <div class="cart__header"><span>Гарантия</span></div>
            <div class="cart__blockItem">
                <div class="cart__blockItemLeft" style="background-image: url(/img/varanty.png);"></div>
                <div class="cart__blockItemRight">
                    <div class="cart__blockItemHeader">Дополнительный год гарантии</div>
                    <div class="cart__blockItemText">tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                    <div class="checkbox">
                        <div class="checkbox__inner">
                            <label class="checkbox__item">
                                <input type="radio" name="varanty" value="0" checked>
                                <span>Спасибо, не надо</span>
                            </label>
                            <label class="checkbox__item">
                                <input type="radio" name="varanty" value="1">
                                <span>Добавить за 2 900 <em class="rubl">₽</em></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cart__block">
        <div class="cart__inner">
            <div class="cart__header"><span>Доставка</span></div>
            <div class="cart__blockItem">
                <div class="cart__blockItemLeft" style="background-image: url(/img/delivery.png);"></div>
                <div class="cart__blockItemRight">
                    <div class="cart__blockItemHeader">Условия доставки</div>
                    <div class="cart__blockItemText">tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="cartForm">
        <div class="container">
            <div class="cartForm__inner">
                <div class="cartForm__left">
                    <div class="cartForm__header">Контакты</div>
                    <div class="form-group cartForm__item1" style="margin-bottom: 10px;">
                        <input type="text" name="name" class="cartForm__input" placeholder="Ваше имя">
                    </div>
                    <div class="form-group cartForm__item2">
                        <input type="text" name="phone" class="cartForm__input" placeholder="Телефон">
                    </div>
                    <div class="form-group cartForm__item2">
                        <input type="text" name="email" class="cartForm__input" placeholder="E-mail">
                    </div>
                    <div class="form-group cartForm__item1 cartForm__itemAddress">
                        <div class="cartForm__addressTrigger" data-fancybox="addressMap" data-src="#addressMap" title="Выберите адрес доставки на карте">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.8 33.2"><g><path d="M11.3,0A11.35,11.35,0,0,0,0,11.3C0,17,9.1,31,10.2,32.6a1.5,1.5,0,0,0,2.4,0c1-1.6,10.2-15.5,10.2-21.3A11.53,11.53,0,0,0,11.3,0Zm0,29.2c-3.1-5-8.5-14.3-8.5-17.9a8.5,8.5,0,0,1,17,0C19.8,14.9,14.5,24.2,11.3,29.2Z"></path><path d="M11.3,7.1a4.8,4.8,0,1,0,4.8,4.8A4.74,4.74,0,0,0,11.3,7.1Zm0,6.9a2.1,2.1,0,1,1,2.1-2.1A2.11,2.11,0,0,1,11.3,14Z"></path></g></svg>
                        </div>
                        <input type="text" name="address" class="cartForm__input" placeholder="Адрес доставки">
                    </div>
                    <div class="form-group cartForm__item1">
                        <textarea name="comm" class="cartForm__input" style="resize: none; height: 100px;" placeholder="Дополнительный комментарий, например: Желаемое время доставки, код от домофона, этаж..."></textarea>
                    </div>
                </div>
                <div class="cartForm__right">
                    <div class="cartForm__header">Оплата</div>
                    <div class="cartForm__headerText">Выберите способ оплаты</div>
                    <div class="checkbox">
                        <div class="checkbox__inner">
                            <label class="checkbox__item">
                                <input type="radio" name="payment" value="0" checked>
                                <i><img src="/img/cards.png" alt=""></i>
                                <span>картой на сайте</span>
                            </label>
                            <label class="checkbox__item">
                                <input type="radio" name="payment" value="1">
                                <i><img src="/img/kurer.svg" alt=""></i>
                                <span>наличными курьеру</span>
                            </label>
                        </div>
                    </div>
                    <div class="cartForm__total">
                        <div class="cartForm__totalHeader">Итого:</div>
                        <div class="cartForm__totalInner">
                            <div class="cartForm__totalItem">
                                <div class="cartForm__totalItemTop">12 000 000</div>
                                <div class="cartForm__totalItemBottom">за товары</div>
                            </div>
                            <div class="cartForm__totalItem">
                                <div class="cartForm__totalItemTop">+</div>
                            </div>
                            <div class="cartForm__totalItem">
                                <div class="cartForm__totalItemTop">350 000</div>
                                <div class="cartForm__totalItemBottom">за услуги</div>
                            </div>
                            <div class="cartForm__totalItem">
                                <div class="cartForm__totalItemTop">=</div>
                            </div>
                            <div class="cartForm__totalItem">
                                <div class="cartForm__totalTotal">12 350 000 <span class="rubl">₽</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cartForm__bottom">
        <div class="container">
            <div class="cartForm__bottomInner">
                <div class="cartForm__bottomLeft">
                    <div class="cartForm__bottomText">Нажимая «купить», вы подтверждаете, что прочли<br>
                        и согласны «<a href="#" class="link">Соглашение с KSG</a>», даёте своё согласие<br>
                        на <a href="#" class="link">обработку персональных данных</a></div>
                </div>
                <div class="cartForm__bottomRight">
                    <button class="button button7 cartForm__submit">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 95.76 35.29"><g><polygon points="8.44 0 0 6.99 0 35.3 87.32 35.3 95.76 28.31 95.76 0 8.44 0"/></g></svg>
                        <span>Купить -></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
