<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Currency $model
*/

$this->title = Yii::t('models', 'Currency');
?>
<div class="giiant-crud currency-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
