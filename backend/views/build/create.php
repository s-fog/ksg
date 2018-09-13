<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Build $model
*/

$this->title = Yii::t('models', 'Build');
?>
<div class="giiant-crud build-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
