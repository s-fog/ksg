<?php

use common\models\Textpage;
use yii\helpers\Url;

$cartCount = \Yii::$app->cart->getCount();
$cartCost = number_format(\Yii::$app->cart->getCost(), 0, ',', ' ');
$favouriteCount = \frontend\models\Favourite::getCount();
$compareCount = \frontend\models\Compare::getCount();

$cartPadezh = '';
$lastLetter = substr((string) $cartCount, -1);
if ($cartCount == 0) {
    $cartPadezh = 'товаров пока нет';
} else if ($lastLetter == '1') {
    $cartPadezh = 'товар';
} else if (in_array($lastLetter, ['2','3','4'])) {
    $cartPadezh = 'товара';
} else if (in_array($lastLetter, ['5','6','7','8','9','0'])) {
    $cartPadezh = 'товаров';
}

$favouritePadezh = '';
$lastLetter = substr((string) $favouriteCount, -1);
if ($favouriteCount == 0) {
    $favouritePadezh = 'товаров пока нет';
} else if ($lastLetter == '1') {
    $favouritePadezh = 'товар';
} else if (in_array($lastLetter, ['2','3','4'])) {
    $favouritePadezh = 'товара';
} else if (in_array($lastLetter, ['5','6','7','8','9','0'])) {
    $favouritePadezh = 'товаров';
}

$comparePadezh = '';
$lastLetter = substr((string) $compareCount, -1);
if ($compareCount == 0) {
    $comparePadezh = 'товаров пока нет';
} else if ($lastLetter == '1') {
    $comparePadezh = 'товар';
} else if (in_array($lastLetter, ['2','3','4'])) {
    $comparePadezh = 'товара';
} else if (in_array($lastLetter, ['5','6','7','8','9','0'])) {
    $comparePadezh = 'товаров';
}

?>

<div class="mainHeader__popupOuter">
    <div class="mainHeader__popupCartInner">
        <div class="mainHeader__popupCartItem">
            <a href="<?=Url::to(['cart/index'])?>" class="mainHeader__popupCartItemTop"><span>В корзине</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40.6 28.6"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M17,21.8a3.4,3.4,0,1,0,3.4,3.4A3.37,3.37,0,0,0,17,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,17,25.8Z"/><path class="cls-1" d="M35.5,21.8a3.4,3.4,0,1,0,3.4,3.4A3.44,3.44,0,0,0,35.5,21.8Zm0,4a.6.6,0,1,1,.6-.6A.65.65,0,0,1,35.5,25.8Z"/><path class="cls-1" d="M39.2,4.8H13.6l-.7-3.7A1.32,1.32,0,0,0,11.5,0H1.4A1.37,1.37,0,0,0,0,1.4,1.37,1.37,0,0,0,1.4,2.8h8.9l2.8,14.8a1.32,1.32,0,0,0,1.4,1.1H35.4a1.4,1.4,0,0,0,0-2.8H15.6l-.5-2.8H37.7a1.4,1.4,0,0,0,0-2.8H14.6l-.5-2.8H39.2a1.37,1.37,0,0,0,1.4-1.4A1.29,1.29,0,0,0,39.2,4.8Z"/></g></svg></a>
            <div class="mainHeader__popupCartItemBottom">
                <?php if ($cartCount == 0) { ?>
                    <?=$cartPadezh?>
                <?php } else { ?>
                    <?=$cartCount?> <?=$cartPadezh?> на <?=$cartCost?> <span class="rubl">₽</span>
                <?php } ?>
            </div>
        </div>
        <div class="mainHeader__popupCartItem">
            <a href="<?=Textpage::getCompareUrl()?>" class="mainHeader__popupCartItemTop"><span>Добавлено к сравнению</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12.37 18.97"><defs><style>.cls-1{fill:#fff;}</style></defs><g><g><path class="cls-1" d="M11.41,19a1,1,0,0,1-1-1V1a1,1,0,0,1,1.92,0V18A1,1,0,0,1,11.41,19Z"/><path class="cls-1" d="M6.18,19a1,1,0,0,1-1-1V6.24a1,1,0,0,1,1.92,0V18A1,1,0,0,1,6.18,19Z"/><path class="cls-1" d="M1,19a1,1,0,0,1-1-1v-7.5a1,1,0,0,1,1.92,0V18A1,1,0,0,1,1,19Z"/></g></g></svg></a>
            <div class="mainHeader__popupCartItemBottom">
                <?php if ($compareCount == 0) { ?>
                    <?=$comparePadezh?>
                <?php } else { ?>
                    <?=$compareCount?> <?=$comparePadezh?>
                <?php } ?>
            </div>
        </div>
        <div class="mainHeader__popupCartItem">
            <a href="<?=Url::to(['site/index', 'alias' => Textpage::findOne(11)->alias])?>" class="mainHeader__popupCartItemTop"><span>В избранном</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.09 16.2"><defs><style>.cls-1{fill:#fff;}</style></defs><g><path class="cls-1" d="M8.05,16.2A1,1,0,0,1,7.42,16C6.66,15.32,0,9.47,0,5.08,0,1.06,2.79,0,4.27,0A4.33,4.33,0,0,1,8.05,1.87,4.3,4.3,0,0,1,11.82,0c1.48,0,4.27,1.06,4.27,5.08,0,4.39-6.66,10.24-7.42,10.89A1,1,0,0,1,8.05,16.2ZM4.27,1.92c-.38,0-2.35.2-2.35,3.16,0,2.69,4,6.9,6.13,8.88,2.15-2,6.12-6.19,6.12-8.88,0-3.07-2.11-3.16-2.35-3.16C9.08,1.92,9,4.72,9,5A1,1,0,1,1,7.09,5C7.08,4.73,7,1.92,4.27,1.92Z"/></g></svg></a>
            <div class="mainHeader__popupCartItemBottom">
                <?php if ($favouriteCount == 0) { ?>
                    <?=$favouritePadezh?>
                <?php } else { ?>
                    <?=$favouriteCount?> <?=$favouritePadezh?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>