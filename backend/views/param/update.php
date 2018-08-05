<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Param $model
*/

$this->title = Yii::t('models', 'Param') . ' Редактирование';
?>
<div class="giiant-crud param-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
