<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Waranty $model
*/

$this->title = Yii::t('models', 'Waranty');
?>
<div class="giiant-crud waranty-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
