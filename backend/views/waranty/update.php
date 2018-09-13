<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Waranty $model
*/

$this->title = Yii::t('models', 'Waranty') . ' Редактирование';
?>
<div class="giiant-crud waranty-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
