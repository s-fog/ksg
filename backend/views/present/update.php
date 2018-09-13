<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Present $model
*/

$this->title = Yii::t('models', 'Present') . ' Редактирование';
?>
<div class="giiant-crud present-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
