<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Textpage $model
*/

$this->title = Yii::t('models', 'Textpage');
?>
<div class="giiant-crud textpage-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
