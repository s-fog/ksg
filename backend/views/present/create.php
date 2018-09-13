<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Present $model
*/

$this->title = Yii::t('models', 'Present');
?>
<div class="giiant-crud present-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
