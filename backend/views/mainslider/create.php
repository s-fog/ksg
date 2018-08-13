<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Mainslider $model
*/

$this->title = Yii::t('models', 'Mainslider');
?>
<div class="giiant-crud mainslider-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
