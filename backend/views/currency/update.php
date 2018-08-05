<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Currency $model
*/

$this->title = Yii::t('models', 'Currency') . ' Редактирование';
?>
<div class="giiant-crud currency-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
