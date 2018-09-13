<?php

$cartCost = $cart->getCost();
$serviceCost = 0;

foreach($positions as $position) {
    $quantity = $position->getQuantity();

    if ($position->build_cost > 0) {
        $serviceCost += $position->build_cost * $quantity;
    }
    if ($position->waranty_cost > 0) {
        $serviceCost += $position->waranty_cost * $quantity;
    }
}

?>
<div class="cartForm__totalHeader">Итого:</div>
<div class="cartForm__totalInner">
    <?php if ($serviceCost == 0) { ?>
        <div class="cartForm__totalItem">
            <div class="cartForm__totalTotal"><?=number_format($serviceCost + $cartCost, 0, '', ' ')?> <span class="rubl">₽</span></div>
        </div>
    <?php } else { ?>
        <div class="cartForm__totalItem">
            <div class="cartForm__totalItemTop"><?=number_format($cartCost, 0, '', ' ')?></div>
            <div class="cartForm__totalItemBottom">за товары</div>
        </div>
        <div class="cartForm__totalItem">
            <div class="cartForm__totalItemTop">+</div>
        </div>
        <div class="cartForm__totalItem">
            <div class="cartForm__totalItemTop"><?=number_format($serviceCost, 0, '', ' ')?></div>
            <div class="cartForm__totalItemBottom">за услуги</div>
        </div>
        <div class="cartForm__totalItem">
            <div class="cartForm__totalItemTop">=</div>
        </div>
        <div class="cartForm__totalItem">
            <div class="cartForm__totalTotal"><?=number_format($serviceCost + $cartCost, 0, '', ' ')?> <span class="rubl">₽</span></div>
        </div>
    <?php } ?>
</div>

<input type="hidden" name="Order[total_cost]" value="<?=($serviceCost + $cartCost)?>">