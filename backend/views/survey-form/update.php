<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\SurveyForm $model
 */

$this->title = 'Просмотр';
?>
<div class="giiant-crud survey-form-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
