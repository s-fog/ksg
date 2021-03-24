<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Delivery $model
*/

$this->title = Yii::t('models', 'Delivery') . ' Редактирование';
?>
<div class="giiant-crud Delivery-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
