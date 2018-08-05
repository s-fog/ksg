<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Category $model
*/

$this->title = Yii::t('models', 'Category') . ' Редактирование';
?>
<div class="giiant-crud category-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'modelsFeature' => $modelsFeature,
        'modelsFeatureValue' => $modelsFeatureValue,
    ]); ?>

</div>
