<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Product $model
*/

$this->title = Yii::t('models', 'Product') . ' Редактирование';
?>
<div class="giiant-crud product-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'modelsImage' => $modelsImage,
        'modelsReview' => $modelsReview,
        'modelsParams' => $modelsParams,
        'modelsFeature' => $modelsFeature,
        'modelsFeatureValue' => $modelsFeatureValue,
    ]); ?>

</div>
