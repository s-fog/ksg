<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Client $model
*/

$this->title = Yii::t('models', 'Client');
?>
<div class="giiant-crud client-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
