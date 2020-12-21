<?php

use common\models\Product;

$presentArtikul = '';

foreach($presents as $present) {
    if ($model->price >= $present->min_price && $model->price <= $present->max_price) {
        $presentArtikul = explode(',', $present->product_artikul)[0];
    }
}

echo $this->render('_addToCart', [
    'model' => $model,
    'popupId' => 'addToCart'.$model->id,
    'presentArtikul' => $presentArtikul
]);

?>