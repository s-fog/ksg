<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Survey $model
*/

$this->title = 'Редактирование';
?>
<div class="giiant-crud survey-update">

    <?php echo $this->render('_form', [
    'model' => $model,
        'modelsStep' => $modelsStep,
        'modelsStepOption' => $modelsStepOption,
    ]); ?>

</div>
