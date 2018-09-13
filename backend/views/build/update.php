<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Build $model
*/

$this->title = Yii::t('models', 'Build') . ' Редактирование';
?>
<div class="giiant-crud build-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
