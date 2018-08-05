<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Supplier $model
*/

$this->title = Yii::t('models', 'Supplier');
?>
<div class="giiant-crud supplier-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
