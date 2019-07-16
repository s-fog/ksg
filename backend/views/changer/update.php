<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Changer $model
*/

$this->title = Yii::t('models', 'Changer') . ' Редактирование';
?>
<div class="giiant-crud changer-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
