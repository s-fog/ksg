<?php

namespace frontend\models;

use yz\shoppingcart\DiscountBehavior;

class MyDiscount extends DiscountBehavior
{
    public $cart;
    public $promocode;

    public function onCostCalculation($event)
    {
        if ($this->promocode->type == 'digit') {
            $event->discountValue = $this->promocode->number;
        } else if ($this->promocode->type == 'percent') {
            $event->discountValue = $this->cart->getCost() * ($this->promocode->number / 100);
        }
    }
}

?>