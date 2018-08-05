<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Product $model
*/

$this->title = Yii::t('models', 'Product');
?>
<div class="giiant-crud product-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelsImage' => $modelsImage,
        'modelsReview' => $modelsReview,
        'modelsParams' => $modelsParams,
        'modelsFeature' => $modelsFeature,
        'modelsFeatureValue' => $modelsFeatureValue,
    ]); ?>

</div>
