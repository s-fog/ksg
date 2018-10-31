<table class="cart__table">
    <tr>
        <th>Наименование</th>
        <th>Цена</th>
        <th>Количество</th>
    </tr>
    <?php
    use common\models\Present;
    use common\models\Product;
    use common\models\ProductParam;
    $products = \Yii::$app->cart->getPositions();

    foreach($products as $product) {
        echo $this->render('_product', ['product' => $product]);
    }

    $cartCost = $cart->getCost();

    foreach($products as $product) {
        if (!empty($product->present_artikul)) {
            $present = $product->getPresent($product->present_artikul);

            echo $this->render('_product', [
                'product' => $present,
                'present' => true,
                'paramsV' => $present->paramsV,
            ]);
        }
    } ?>
</table>