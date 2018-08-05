<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Adviser $model
*/

$this->title = Yii::t('models', 'Adviser') . ' Редактирование';
?>
<div class="giiant-crud adviser-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
