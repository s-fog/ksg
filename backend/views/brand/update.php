<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Brand $model
*/

$this->title = Yii::t('models', 'Brand') . ' Редактирование';
?>
<div class="giiant-crud brand-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
