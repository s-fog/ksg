<?php
use common\models\Param;
use common\models\Product;
use yii\helpers\Url;

if (!isset($popupId)) {
    $popupId = 'addToCart';
}

if (!isset($presentArtikul)) {
    $presentArtikul = '';
}

if (!isset($delivery_date)) {
    $delivery_date = '';
}

?>
<div class="popup addToCart__wrapper"
     <?php
     if (isset($_POST) && !empty($_POST['reload'])) {
         if (isset($_POST['popupShow']) && $_POST['popupShow'] == 1) {
             echo 'style="display: inline-block;"';
         }
     }
     ?>
     id="<?=$popupId?>"
     data-id="<?=$model->id?>"
     data-delivery_date="<?=$delivery_date?>"
     data-present_artikul="<?=$presentArtikul?>">
    <?=$this->render('_addToCartInner', [
        'model' => $model,
        'presentArtikul' => $presentArtikul
    ])?>
</div>