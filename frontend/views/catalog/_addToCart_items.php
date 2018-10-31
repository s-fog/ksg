<?php

use common\models\Product;

$currentParams = [];
$selects = [];
$variants = $model->params;
$currentVariant = $variants[0];
$i = 0;

if ($currentVariant->params) {
    foreach($currentVariant->params as $p) {
        $name = explode(' -> ', $p)[0];
        $value = explode(' -> ', $p)[1];
        $currentParams[$name] = $value;
    }
}

foreach($variants as $v) {
    if ($v->params) {
        foreach($v->params as $param) {
            $name = explode(' -> ', $param)[0];
            $value = explode(' -> ', $param)[1];

            if (!isset($selects[$name]) || !Product::in_array_in($value, $selects, $name)) {
                $selects[$name][$i]['value'] = $value;

                if ($currentParams[$name] == $value) {
                    $selects[$name][$i]['active'] = true;
                } else {
                    $selects[$name][$i]['active'] = false;
                }

                $i++;
            }
        }
    }
}

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
    'popupId' => 'addToCart'.$model->id,
    'presentArtikul' => $presentArtikul
]);

?>