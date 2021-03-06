<?php
use common\models\Param;
use common\models\Product;
use yii\helpers\Url;

$empty = false;

if ($model->params[0]->available == 0) {
    $empty = true;
}

?>
<div class="addToCart">
    <div class="addToCart__beforeHeader">Добавить в корзину</div>
    <div class="addToCart__header"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?> <?=number_format($model->price, 0, '', ' ')?> <span class="rubl">₽</span></div>
    <?php
    $image0 = $model->images[$model->params[0]->image_number];
    $filename = explode('.', basename($image0->image)); ?>
    <div class="addToCart__image"><div style="background-image: url(/images/thumbs/<?=$filename[0]?>-770-553.<?=$filename[1]?>);"></div></div>
    <div class="addToCart__features">
        <div class="addToCart__feature">
            <div class="addToCart__featureHeader">Количество</div>
            <div class="addToCart__featureBottom cart__countInner">
                <div class="cart__countMinus"></div>
                <input type="text" name="count" class="cart__countInput js-cant-zero" value="1">
                <div class="cart__countPlus"></div>
            </div>
        </div>
        <?=$this->render('@frontend/views/catalog/selects', ['model' => $model])?>
    </div>
    <div class="addToCart__bottom">
        <div class="addToCart__bottomTop">
            <button class="button button222 addToCart__tocart">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 34"><g><polygon points="7.07 0 0 7.07 0 34 211.93 34 219 26.93 219 0 7.07 0"></polygon></g></svg>
                <span>Добавить в корзину</span>
            </button>
        </div>
        <div class="addToCart__bottomBottom">
            <a href="<?=Url::to(['cart/index'])?>" class="button button222 addToCart__of">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 34"><g><polygon points="7.07 0 0 7.07 0 34 211.93 34 219 26.93 219 0 7.07 0"></polygon></g></svg>
                <span>Перейти к оформлению</span>
            </a>
            <div class="addToCart__continue"><span>Продолжить покупки</span></div>
        </div>
    </div>
</div>