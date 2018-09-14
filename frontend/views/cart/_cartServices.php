<?php
use common\models\Build;
use common\models\Waranty;

foreach($positions as $position) {
    if ($build = Build::findOne(['category_id' => $position->parent_id])) {
        $quantity = $position->getQuantity();
        $buildCost = $quantity * $build->price;
        $checked = false;

        if ($position->build_cost !== NULL && $position->build_cost !== false && $position->build_cost >= 0) {
            $checked = true;
        }

        $buildBlock = '';

        if ($build->price == 0) {
            $buildBlock = 'Добавить за Бесплатно';
        } else {
            if ($quantity == 1) {
                $buildBlock = 'Добавить за '.number_format($buildCost, 0, '', ' ').' <em class="rubl">₽</em>';
            } else {
                $buildBlock = 'Добавить за '.number_format($build->price, 0, '', ' ').' * '.$quantity.' = '.number_format($buildCost, 0, '', ' ').' <em class="rubl">₽</em>';
            }
        }

        echo '<div class="cart__block">
                    <div class="cart__inner">
                        <div class="cart__header"><span>Сборка '.$quantity.'x '.$position->name.'</span></div>
                        <div class="cart__blockItem">
                            <div class="cart__blockItemLeft" style="background-image: url(/img/construct.png);"></div>
                            <div class="cart__blockItemRight">
                                <div class="cart__blockItemHeader">Сборка специалистами KSG</div>
                                <div class="cart__blockItemText">'.$build->text.'</div>
                                <div class="checkbox">
                                    <div class="checkbox__inner">
                                        <label class="checkbox__item">
                                            <input class="js-service-change" type="radio" name="Order[build]['.$position->getId().']" value="false"'.(($checked) ? '': ' checked').'>
                                            <span>Спасибо, не надо</span>
                                        </label>
                                        <label class="checkbox__item">
                                            <input class="js-service-change" type="radio" name="Order[build]['.$position->getId().']" value="'.$build->price.'"'.(($checked) ? ' checked': '').'>
                                            <span>'.$buildBlock.'</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    ?>
    <?php
    if ($waranty = Waranty::findOne(['category_id' => $position->parent_id])) {
        $quantity = $position->getQuantity();
        $warantyCost = $quantity * $waranty->price;
        $checked = false;

        if ($position->waranty_cost !== NULL && $position->waranty_cost !== false && $position->waranty_cost >= 0) {
            $checked = true;
        }

        $warantyBlock = '';

        if ($waranty->price == 0) {
            $warantyBlock = 'Добавить за Бесплатно';
        } else {
            if ($quantity == 1) {
                $warantyBlock = 'Добавить за '.number_format($warantyCost, 0, '', ' ').' <em class="rubl">₽</em>';
            } else {
                $warantyBlock = 'Добавить за '.number_format($waranty->price, 0, '', ' ').' * '.$quantity.' = '.number_format($warantyCost, 0, '', ' ').' <em class="rubl">₽</em>';
            }
        }

        echo '<div class="cart__block">
                    <div class="cart__inner">
                        <div class="cart__header"><span>Гарантия ' . $quantity . 'x ' . $position->name . '</span></div>
                        <div class="cart__blockItem">
                            <div class="cart__blockItemLeft" style="background-image: url(/img/varanty.png);"></div>
                            <div class="cart__blockItemRight">
                                <div class="cart__blockItemHeader">Дополнительный год гарантии</div>
                                <div class="cart__blockItemText">' . $waranty->text . '</div>
                                <div class="checkbox">
                                    <div class="checkbox__inner">
                                        <label class="checkbox__item">
                                            <input class="js-service-change" type="radio" name="Order[waranty][' . $position->getId() . ']" value="false"'.(($checked) ? '': ' checked').'>
                                            <span>Спасибо, не надо</span>
                                        </label>
                                        <label class="checkbox__item">
                                            <input class="js-service-change" type="radio" name="Order[waranty][' . $position->getId() . ']" value="' . $waranty->price . '"'.(($checked) ? ' checked': '').'>
                                            <span>'.$warantyBlock.'</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    ?>
<?php } ?>