<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Mainslider $model
*/

$this->title = Yii::t('models', 'Mainslider') . ' Редактирование';
?>
<div class="giiant-crud mainslider-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
