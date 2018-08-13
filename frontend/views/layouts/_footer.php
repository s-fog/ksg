<?php

use common\models\Brand;
use common\models\Category;
use common\models\Textpage;
use frontend\models\SubscribeForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


?>


<div class="footer">
    <div class="container">
        <div class="footer__inner">
            <div class="footer__item">
                <div class="footer__itemHeader">ИНФОРМАЦИЯ И СЕРВИС</div>
                <ul class="footer__itemMenu">
                    <li><a href="#" class="footer__itemMenuLink">Доставка</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Способы оплаты</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Обмен и возврат</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Гарантийное обслуживание</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Покупка в кредит</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Юридическим лицам</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Фитнес зал "под ключ"</a></li>
                </ul>
            </div>
            <div class="footer__item">
                <div class="footer__itemHeader">О КОМПАНИИ</div>
                <ul class="footer__itemMenu">
                    <li><a href="#" class="footer__itemMenuLink">Юридическая информация</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Сотрудничество</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Вакансии</a></li>
                    <li><a href="#" class="footer__itemMenuLink">График работы</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Пользовательское соглашение</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Отзывы</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Наш блог</a></li>
                    <li><a href="#" class="footer__itemMenuLink">Партнерская программа</a></li>
                </ul>
            </div>
            <div class="footer__item">
                <div class="footer__itemHeader">КОНТАКТЫ</div>
                <ul class="footer__itemMenu">
                    <li>В Москве: <a href="tel:+74957775544" class="linkReverse">+7 495 777 55 44</a></li>
                    <li>Для регионов: <a href="tel:+78007775544" class="linkReverse">8 800 777 55 44</a></li>
                    <li>E-mail: <a href="mailto:hello@ksg.ru" class="linkReverse">hello@ksg.ru</a></li>
                    <li>
                        <div class="button button1 callbackButton" data-fancybox data-src="#callback">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"/></g></g></svg>
                            <span>заказать обратный звонок</span>
                        </div>
                    </li>
                    <li class="footer__address">г. Москва, ул Пятницкая дом 1,<br>
                        строение 1, офис 1</li>
                </ul>
            </div>
        </div>
        <div class="footer__inner">
            <div class="footer__item footer__item_bottom">ООО "КейЭсДжи"<br>
                Интернет-магазин спортивного инвентаря.
                2018 – Все права защищены.</div>
            <div class="footer__item footer__item_bottom">
                <a href="#" class="footer__itemLink linkSpanReverse"><span>Полный каталог</span></a>
                <a href="#" class="footer__itemLink linkSpanReverse"><span>Бренды-партнёры KSG</span></a>
                <a href="#" class="footer__itemLink linkSpanReverse"><span>Политика конфиденциальности</span></a>
            </div>
            <div class="footer__item socials">
                <a href="#" class="socials__item" target="_blank" rel="nofollow" style="background-image: url(/img/fb_icon.svg);"></a>
                <a href="#" class="socials__item" target="_blank" rel="nofollow" style="background-image: url(/img/vk_icon.svg);"></a>
                <a href="#" class="socials__item" target="_blank" rel="nofollow" style="background-image: url(/img/youtube_icon.svg);"></a>
                <a href="#" class="socials__item" target="_blank" rel="nofollow" style="background-image: url(/img/instagram_icon.svg);"></a>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="footer__bottomInner">
                <div class="footer__bottomLeft">Вы достигли дна сайта, и это либо результат упорства (что мы категорически приветствуем!),
                    либо вы не нашли, то что искали. Во втором случаи предлагем воспользоваться:</div>
                <div class="footer__bottomRight">
                    <a href="#" class="footer__bottomLink">
                        <svg class="footer__bottomLinkIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><defs></defs><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg>
                        <span>поиск по сайту</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<form class="popup callback sendForm" id="callback">
    <div class="callback__inner">
        <div class="callback__left">
            <div class="callback__image"></div>
        </div>
        <div class="callback__right">
            <div class="callback__header">Специалист  оперативно перезвонит
                и ответит на все вопросы.</div>
            <div class="form-group">
                <input type="text" name="name" placeholder="Имя" class="callback__input">
            </div>
            <div class="form-group">
                <input type="text" name="phone" placeholder="Телефон" class="callback__input">
            </div>
            <button class="popup__submit" type="submit">заказать обратный звонок</button>
        </div>
    </div>
    <div class="callback__bottom">Нажимая «заказать обрытный звонок», вы подтверждаете, что прочли и согласны
        «<a href="#" class="link">Соглашение с KSG</a>», даёте своё согласиена <a href="#" class="link">обработку персональных данных</a></div>
</form>

<form class="popup oneClick sendForm" id="oneClick">
    <div class="addToCart__beforeHeader">Быстрая покупка: наш менеджер оформит заказ по телефону</div>
    <div class="addToCart__header"></div>
    <div class="addToCart__image"><div style="background-image: url()"></div></div>
    <div class="oneClick__inner">
        <div class="oneClick__top">
            <div class="form-group">
                <input type="text" name="name" placeholder="Имя" class="callback__input">
            </div>
            <div class="form-group">
                <input type="text" name="phone" placeholder="Телефон" class="callback__input">
            </div>
        </div>
        <div class="oneClick__bottom">
            <div class="oneClick__bottomLeft">
                <div class="callback__bottom">Нажимая «заказать обрытный звонок», вы подтверждаете, что прочли и согласны
                    «<a href="#" class="link">Соглашение с KSG</a>», даёте своё согласиена <a href="#" class="link">обработку персональных данных</a></div>
            </div>
            <div class="oneClick__bottomRight">
                <button class="popup__submit" type="submit">купить</button>
            </div>
        </div>
    </div>
</form>
