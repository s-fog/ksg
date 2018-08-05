<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Brand $model
*/

$this->title = Yii::t('models', 'Brand');
?>
<div class="giiant-crud brand-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
