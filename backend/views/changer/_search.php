<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var common\models\ChangerSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="changer-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'created_at') ?>

		<?= $form->field($model, 'updated_at') ?>

		<?= $form->field($model, 'product_id') ?>

		<?= $form->field($model, 'old_price') ?>

		<?php // echo $form->field($model, 'new_price') ?>

		<?php // echo $form->field($model, 'percent') ?>

		<?php // echo $form->field($model, 'supplier_id') ?>

		<?php // echo $form->field($model, 'brand_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
