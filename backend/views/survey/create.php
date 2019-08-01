<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Survey $model
*/

$this->title = 'Создание';
?>
<div class="giiant-crud survey-create">

    <?= $this->render('_form', [
    'model' => $model,
    'modelsStep' => $modelsStep,
    'modelsStepOption' => $modelsStepOption,
    ]); ?>

</div>
