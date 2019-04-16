<?php

use common\models\Product;

$currentVariant = $model->productParams[0];
$selectsAndDisabled = $model->getSelectsAndDisabled($currentVariant);
$selects = $selectsAndDisabled[0];
$disabled = $selectsAndDisabled[1];

$presentArtikul = '';
foreach($presents as $present) {
    if ($model->price >= $present->min_price && $model->price <= $present->max_price) {
        $presentArtikul = explode(',', $present->product_artikul)[0];
    }
}

echo $this->render('_addToCart', [
    'model' => $model,
    'currentVariant' => $currentVariant,
    'selects' => $selects,
    'disabled' => $disabled,
    'popupId' => 'addToCart'.$model->id,
    'presentArtikul' => $presentArtikul
]);

?>