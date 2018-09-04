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
    <?php
    foreach(\Yii::$app->cart->getPositions() as $product) {
        echo $this->render('_product', ['product' => $product]);
    }
    ?>
</table>