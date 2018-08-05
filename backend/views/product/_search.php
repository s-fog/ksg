<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var common\models\ProductSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'alias') ?>

		<?= $form->field($model, 'code') ?>

		<?= $form->field($model, 'hit') ?>

		<?php // echo $form->field($model, 'parent_id') ?>

		<?php // echo $form->field($model, 'brand_id') ?>

		<?php // echo $form->field($model, 'supplier') ?>

		<?php // echo $form->field($model, 'artikul') ?>

		<?php // echo $form->field($model, 'price') ?>

		<?php // echo $form->field($model, 'price_old') ?>

		<?php // echo $form->field($model, 'currency_id') ?>

		<?php // echo $form->field($model, 'description') ?>

		<?php // echo $form->field($model, 'features') ?>

		<?php // echo $form->field($model, 'adviser_id') ?>

		<?php // echo $form->field($model, 'adviser_text') ?>

		<?php // echo $form->field($model, 'instruction') ?>

		<?php // echo $form->field($model, 'video') ?>

		<?php // echo $form->field($model, 'disallow_xml') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'seo_h1') ?>

		<?php // echo $form->field($model, 'seo_title') ?>

		<?php // echo $form->field($model, 'seo_keywords') ?>

		<?php // echo $form->field($model, 'seo_description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
