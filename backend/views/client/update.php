<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Client $model
*/

$this->title = Yii::t('models', 'Client') . ' Редактирование';
?>
<div class="giiant-crud client-update">

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
