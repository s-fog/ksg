<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Callback $model
*/

$this->title = Yii::t('models', 'Callback') . ' Редактирование';
?>
<div class="giiant-crud callback-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
