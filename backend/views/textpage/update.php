<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Textpage $model
*/

$this->title = Yii::t('models', 'Textpage') . ' Редактирование';
?>
<div class="giiant-crud textpage-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
