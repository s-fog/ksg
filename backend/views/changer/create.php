<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Changer $model
*/

$this->title = Yii::t('models', 'Changer');
?>
<div class="giiant-crud changer-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
