<?php

use common\models\Brand;
use common\models\Category;
use common\models\Textpage;
use frontend\models\CallbackForm;
use frontend\models\OneClickForm;
use frontend\models\SubscribeForm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$cache = Yii::$app->cache;

$infoAndService = Textpage::findOne(8);
$company = Textpage::findOne(9);

$array = Yii::$app->params['cities'];
$moscow = $array['Москва'];
$others = $array['Others'];

?>


<div class="footer">
    <div class="container">
        <div class="footer__inner">
            <div class="footer__item">
                <div class="footer__itemHeader"><?=$infoAndService->name?></div>
                <ul class="footer__itemMenu">
                    <?php
                    if (!$textpages1 = $cache->get('textpages1')){
                        $textpages1 = Textpage::find()
                            ->where(['type' => 1])
                            ->orderBy(['sort_order' => SORT_DESC])
                            ->all();
                        $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT updated_at FROM textpage ORDER BY updated_at DESC']);
                        $cache->set('textpages1', $textpages1, null, $dependency);
                    }

                    foreach($textpages1 as $textpage) { ?>
                    <li><a href="<?=Url::to([
                            'site/index',
                            'alias' => $infoAndService->alias,
                            'alias2' => $textpage->alias,
                        ])?>" class="footer__itemMenuLink"><?=$textpage->name?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="footer__item">
                <div class="footer__itemHeader"><?=$company->name?></div>
                <ul class="footer__itemMenu">
                    <?php
                    if (!$textpages2 = $cache->get('textpages2')){
                        $textpages2 = Textpage::find()
                            ->where(['type' => 2])
                            ->orderBy(['sort_order' => SORT_DESC])
                            ->all();
                        $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT updated_at FROM textpage ORDER BY updated_at DESC']);
                        $cache->set('textpages2', $textpages2, null, $dependency);
                    }
                    foreach($textpages2 as $textpage) { ?>
                        <li><a href="<?=Url::to([
                                'site/index',
                                'alias' => $company->alias,
                                'alias2' => $textpage->alias,
                            ])?>" class="footer__itemMenuLink"><?=$textpage->name?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="footer__item">
                <a href="<?=Url::to(['site/index', 'alias' => Textpage::findOne(14)->alias])?>" class="footer__itemHeader linkSpanReverse"><span>КОНТАКТЫ</span></a>
                <ul class="footer__itemMenu">
                    <li>В Москве: <a href="tel:<?=$moscow['phoneLink']?>" class="linkReverse"><?=$moscow['phone']?></a></li>
                    <li>Для регионов: <a href="tel:<?=$others['phoneLink']?>" class="linkReverse"><?=$others['phone']?></a></li>
                    <li>E-mail: <a href="mailto:<?=$moscow['email']?>" class="linkReverse"><?=$moscow['email']?></a></li>
                    <li>
                        <div class="button button1 callbackButton" data-fancybox data-src="#callback">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"/></g></g></svg>
                            <span>заказать обратный звонок</span>
                        </div>
                    </li>
                    <li class="footer__address"><?=$moscow['addressBr']?></li>
                </ul>
            </div>
        </div>
        <div class="footer__inner">
            <div class="footer__item footer__item_bottom">ООО "КейЭсДжи"<br>
                Спортивный интернет-магазин.<br>
                2018 – Все права защищены.</div>
            <div class="footer__item footer__item_bottom">
                <a href="<?=Url::to(['site/index', 'alias' => Textpage::findOne(13)->alias])?>" class="footer__itemLink linkSpanReverse"><span>Наш блог</span></a>
                <a href="<?=Url::to(['site/index', 'alias' => Textpage::findOne(1)->alias])?>" class="footer__itemLink linkSpanReverse"><span>Полный каталог</span></a>
                <a href="<?=Url::to(['site/index', 'alias' => Textpage::findOne(2)->alias])?>" class="footer__itemLink linkSpanReverse"><span>Бренды-партнёры KSG</span></a>
                <a href="/documents/politics.pdf" target="_blank" class="footer__itemLink linkSpanReverse"><span>Политика конфиденциальности</span></a>
            </div>
            <div class="footer__item socials">
                <a href="https://www.facebook.com/KSG-%D0%A1%D0%BF%D0%BE%D1%80%D1%82%D0%B8%D0%B2%D0%BD%D1%8B%D0%B9-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD-1908512709457176/" class="socials__item" target="_blank" rel="nofollow" style="background-image: url(/img/fb_icon.svg);"></a>
                <a href="https://vk.com/ksgru" class="socials__item" target="_blank" rel="nofollow" style="background-image: url(/img/vk_icon.svg);"></a>
                <a href="https://www.youtube.com/channel/UC2qnabldyyfflW51ngTw3Gw" class="socials__item" target="_blank" rel="nofollow" style="background-image: url(/img/youtube_icon.svg);"></a>
                <a href="https://www.instagram.com/ksgrussia/" class="socials__item" target="_blank" rel="nofollow" style="background-image: url(/img/instagram_icon.svg);"></a>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <div class="footer__bottomInner">
                <div class="footer__bottomLeft">Вы достигли дна сайта, и это либо результат упорства (что мы категорически приветствуем!), либо вы не нашли, что искали. Во втором случае используйте:</div>
                <div class="footer__bottomRight">
                    <div class="footer__bottomLink js-footer__bottomLink">
                        <svg class="footer__bottomLinkIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><defs></defs><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg>
                        <span>поиск по сайту</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$callbackForm = new CallbackForm();
$form = ActiveForm::begin([
    'options' => [
        'class' => 'popup callback sendForm',
        'id' => 'callback'
    ],
]);?>
<div class="callback__inner">
    <div class="callback__left">
        <div class="callback__image"></div>
    </div>
    <div class="callback__right">
        <div class="callback__header">Специалист  оперативно перезвонит
            и ответит на все вопросы.</div>
    <?=$form->field($callbackForm, 'name')
        ->textInput([
            'class' => 'callback__input',
            'placeholder' => 'Имя'
        ])->label(false)?>
    <?=$form->field($callbackForm, 'phone')->widget(MaskedInput::className(), [
        'mask' => '+7 (999) 999-99-99',
        'options' => [
            'class' => 'callback__input',
            'id' => 'callback_phone_mask',
            'placeholder' => 'Телефон'
        ],
        'clientOptions' => [
            'clearIncomplete' => true
        ]
    ])->label(false) ?>
        <button class="popup__submit" type="submit">заказать обратный звонок</button>
    </div>
</div>
<div class="callback__bottom">
    Нажимая «заказать обратный звонок», вы подтверждаете, что прочли и согласны
    с “<a href="/kompaniya/publichnaya-oferta" target="_blank" class="link">Публичной офертой</a>”, и даёте своё согласие на <a href="/documents/politics.pdf" target="_blank" class="link">обработку персональных данных</a>.
</div>

<?=$form->field($callbackForm, 'type')
    ->hiddenInput([
        'value' => 'Обратный звонок KSG'
    ])->label(false)?>

<?=$form->field($callbackForm, 'BC')
    ->textInput([
        'class' => 'BC',
        'value' => ''
    ])->label(false)?>
<?php ActiveForm::end();?>

<?php
$oneClickForm = new OneClickForm();
$form = ActiveForm::begin([
    'options' => [
        'class' => 'popup oneClick sendForm',
        'id' => 'oneClick'
    ],
]);?>
<div class="addToCart__beforeHeader">Быстрая покупка: наш менеджер оформит заказ по телефону</div>
<div class="addToCart__header"></div>
<div class="addToCart__image"><div style="background-image: url()"></div></div>
<div class="oneClick__inner">
    <div class="oneClick__top">
    <?=$form->field($oneClickForm, 'name')
        ->textInput([
            'class' => 'callback__input',
            'placeholder' => 'Имя'
        ])->label(false)?>
    <?=$form->field($oneClickForm, 'phone')->widget(MaskedInput::className(), [
        'mask' => '+7 (999) 999-99-99',
        'options' => [
            'class' => 'callback__input',
            'id' => 'oneclick_phone_mask',
            'placeholder' => 'Телефон'
        ],
        'clientOptions' => [
            'clearIncomplete' => true
        ]
    ])->label(false) ?>
    </div>
    <div class="oneClick__bottom">
        <div class="oneClick__bottomLeft">
            <div class="callback__bottom">
                Нажимая «купить», вы подтверждаете, что прочли<br>
                и согласны  с “<a href="/kompaniya/publichnaya-oferta" target="_blank" class="link">Публичной офертой</a>”, и даёте своё согласие<br>
                на <a href="/documents/politics.pdf" target="_blank" class="link">обработку персональных данных</a>
            </div>
        </div>
        <div class="oneClick__bottomRight">
            <button class="popup__submit" type="submit">купить</button>
        </div>
    </div>
</div>
<?=$form->field($oneClickForm, 'type')
    ->hiddenInput([
        'value' => 'Купить в один клик KSG'
    ])->label(false)?>
<?=$form->field($oneClickForm, 'paramsV')
    ->hiddenInput([
        'value' => ''
    ])->label(false)?>
<?=$form->field($oneClickForm, 'product_id')
    ->hiddenInput([
        'value' => ''
    ])->label(false)?>

<?=$form->field($oneClickForm, 'BC')
    ->textInput([
        'class' => 'BC',
        'value' => ''
    ])->label(false)?>
<?php ActiveForm::end();?>

<div class="popup" id="addToCartNoParams">
    <div class="addToCart">
        <div class="addToCart__beforeHeader">Добавлено в корзину</div>
        <div class="addToCart__bottom">
            <a href="<?=Url::to(['cart/index'])?>" class="button button222 addToCart__of">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 34"><g><polygon points="7.07 0 0 7.07 0 34 211.93 34 219 26.93 219 0 7.07 0"></polygon></g></svg>
                <span>Перейти к оформлению</span>
            </a>
            <div class="addToCart__continue"><span>Продолжить покупки</span></div>
        </div>
    </div>
</div>
