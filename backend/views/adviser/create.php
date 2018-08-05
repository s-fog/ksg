<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Adviser $model
*/

$this->title = Yii::t('models', 'Adviser');
?>
<div class="giiant-crud adviser-create">

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
