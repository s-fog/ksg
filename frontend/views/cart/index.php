<?php
use common\models\Mainpage;
use frontend\models\Order;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->params['seo_title'] = '';
$this->params['seo_description'] = '';
$this->params['seo_keywords'] = '';
$this->params['name'] = 'Корзина';

$cart = Yii::$app->cart;
$positions = $cart->getPositions();

$mainPage = Mainpage::findOne(1);

?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => [0 => 'Корзина']])?>

<?php
$cartForm = new Order();
$form = ActiveForm::begin([
        'options' => [
        'action' => 'cart',
        'class' => 'cart',
        'id' => 'cartForm'
    ],
]);?>
<h1 class="header">Корзина</h1>
<div class="cart__block">
    <div class="cart__inner">
        <?=$this->render('_products', [
            'cart' => $cart,
            'positions' => $positions,
        ])?>
    </div>
</div>
<br><br>
<div class="cart__services">
    <?=$this->render('_cartServices', [
        'cart' => $cart,
        'positions' => $positions
    ])?>
</div>
<div class="cart__block">
    <div class="cart__inner">
        <div class="cart__header"><span>Доставка</span></div>
        <div class="cart__blockItem">
            <div class="cart__blockItemLeft" style="background-image: url(/img/delivery.png);"></div>
            <div class="cart__blockItemRight">
                <div class="cart__blockItemHeader">Условия доставки</div>
                <div class="cart__blockItemText"><?=$mainPage->delivery?></div>
            </div>
        </div>
    </div>
</div>
<div class="cartForm">
    <div class="container">
        <div class="cartForm__inner">
            <div class="cartForm__left">
                <div class="cartForm__header">Контакты</div>
                <div class="cartForm__item1" style="margin-bottom: 10px;">
                    <?=$form->field($cartForm, 'name')
                        ->textInput([
                            'class' => 'cartForm__input',
                            'placeholder' => 'Ваше имя'
                        ])->label(false)?>
                </div>
                <div class="cartForm__item2">
                    <?=$form->field($cartForm, 'phone')
                        ->widget(MaskedInput::className(), [
                            'mask' => '+7 (999) 999-99-99',
                            'id' => 'mask',
                            'options' => [
                                'class' => 'cartForm__input',
                                'placeholder' => 'Телефон'
                            ],
                            'clientOptions' => [
                                'clearIncomplete' => true
                            ]
                        ])->label(false)?>
                </div>
                <div class="cartForm__item2">
                    <?=$form->field($cartForm, 'email')
                        ->textInput([
                            'class' => 'cartForm__input',
                            'placeholder' => 'E-mail'
                        ])->label(false)?>
                </div>
                <div class="cartForm__item1 cartForm__itemAddress">
                    <div class="cartForm__addressTrigger" data-fancybox="addressMap" data-src="#addressMap" title="Выберите адрес доставки на карте">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.8 33.2"><g><path d="M11.3,0A11.35,11.35,0,0,0,0,11.3C0,17,9.1,31,10.2,32.6a1.5,1.5,0,0,0,2.4,0c1-1.6,10.2-15.5,10.2-21.3A11.53,11.53,0,0,0,11.3,0Zm0,29.2c-3.1-5-8.5-14.3-8.5-17.9a8.5,8.5,0,0,1,17,0C19.8,14.9,14.5,24.2,11.3,29.2Z"></path><path d="M11.3,7.1a4.8,4.8,0,1,0,4.8,4.8A4.74,4.74,0,0,0,11.3,7.1Zm0,6.9a2.1,2.1,0,1,1,2.1-2.1A2.11,2.11,0,0,1,11.3,14Z"></path></g></svg>
                    </div>
                    <?=$form->field($cartForm, 'address')
                        ->textInput([
                            'class' => 'cartForm__input',
                            'placeholder' => 'Адрес доставки'
                        ])->label(false)?>
                </div>
                <div class="cartForm__item1">
                    <?=$form->field($cartForm, 'comm')
                        ->textarea([
                            'style' => 'resize: none; height: 100px;',
                            'class' => 'cartForm__input',
                            'placeholder' => 'Дополнительный комментарий, например: Желаемое время доставки, код от домофона, этаж...'
                        ])->label(false)?>
                </div>
            </div>
            <div class="cartForm__right">
                <div class="cartForm__header">Оплата</div>
                <div class="cartForm__headerText">Выберите способ оплаты</div>
                <div class="checkbox">
                    <div class="checkbox__inner">
                        <label class="checkbox__item">
                            <input type="radio" name="Order[payment]" value="0" checked>
                            <i><img src="/img/cards.png" alt=""></i>
                            <span>картой на сайте</span>
                        </label>
                        <label class="checkbox__item">
                            <input type="radio" name="Order[payment]" value="1">
                            <i><img src="/img/kurer.svg" alt=""></i>
                            <span>наличными курьеру</span>
                        </label>
                    </div>
                </div>
                <div class="cartForm__total">
                    <?=$this->render('_cartTotal', [
                        'cart' => $cart,
                        'positions' => $positions
                    ])?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cartForm__bottom">
    <div class="container">
        <div class="cartForm__bottomInner">
            <div class="cartForm__bottomLeft">
                <div class="cartForm__bottomText">
                    Нажимая «купить», вы подтверждаете, что прочли<br>
                    и согласны  с “<a href="/kompaniya/publichnaya-oferta" target="_blank" class="link">Публичной офертой</a>”, и даёте своё согласие<br>
                    на <a href="/documents/politics.pdf" target="_blank" class="link">обработку персональных данных</a></div>
            </div>
            <div class="cartForm__bottomRight">
                <button class="button button7 cartForm__submit" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 95.76 35.29"><g><polygon points="8.44 0 0 6.99 0 35.3 87.32 35.3 95.76 28.31 95.76 0 8.44 0"/></g></svg>
                    <span>Купить -></span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end();?>

