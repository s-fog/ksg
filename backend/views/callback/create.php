<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Callback $model
*/

$this->title = Yii::t('models', 'Callback');
?>
<div class="giiant-crud callback-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
