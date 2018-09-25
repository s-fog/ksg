<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Subscribe $model
*/

$this->title = Yii::t('models', 'Subscribe');
?>
<div class="giiant-crud subscribe-update">

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
