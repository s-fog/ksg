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

    foreach(\Yii::$app->cart->getPositions() as $product) {
        echo $this->render('_product', ['product' => $product]);
    }

    $cartCost = $cart->getCost();

    if ($present = Present::find()->where("$cartCost >= min_price AND $cartCost < max_price")->one()) {
        $productParam = ProductParam::findOne(['artikul' => $present->product_artikul]);
        $productPresent = Product::findOne($productParam->product_id);
        $paramsV = implode('|', $productParam->params);
        $productPresent->paramsV = $paramsV;
        echo '<input type="hidden" name="Order[present_artikul]" value="'.$present->product_artikul.'">';

        echo $this->render('_product', [
            'product' => $productPresent,
            'present' => true,
            'paramsV' => $paramsV,
        ]);
    } ?>
</table>