<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var common\models\OrderSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'delivery') ?>

		<?= $form->field($model, 'payments') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'phone') ?>

		<?php // echo $form->field($model, 'email') ?>

		<?php // echo $form->field($model, 'shipaddress') ?>

		<?php // echo $form->field($model, 'comment') ?>

		<?php // echo $form->field($model, 'products') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
