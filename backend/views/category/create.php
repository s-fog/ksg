<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Category $model
*/

$this->title = Yii::t('models', 'Category');
?>
<div class="giiant-crud category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelsFeature' => $modelsFeature,
        'modelsStep' => $modelsStep,
        'modelsFilterFeature' => $modelsFilterFeature,
        'modelsFeatureValue' => $modelsFeatureValue,
    ]); ?>

</div>
