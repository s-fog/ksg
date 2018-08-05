<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Mainpage $model
*/

$this->title = $model->name;
?>
<div class="giiant-crud mainpage-update">

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
