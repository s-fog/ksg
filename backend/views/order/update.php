<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Order $model
*/
    
$this->title = Yii::t('models', 'Order') . " " . $model->name;
?>
<div class="giiant-crud order-update">

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
