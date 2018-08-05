<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Param $model
*/

$this->title = Yii::t('models', 'Param');
?>
<div class="giiant-crud param-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
