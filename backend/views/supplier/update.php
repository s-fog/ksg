<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Supplier $model
*/

$this->title = Yii::t('models', 'Supplier') . ' Редактирование';
?>
<div class="giiant-crud supplier-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
