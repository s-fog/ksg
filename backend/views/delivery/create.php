<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Delivery $model
*/

$this->title = Yii::t('models', 'Delivery');
?>
<div class="giiant-crud Delivery-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
