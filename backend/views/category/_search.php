<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var common\models\CategorySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'alias') ?>

		<?= $form->field($model, 'type') ?>

		<?= $form->field($model, 'features') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'sort_order') ?>

		<?php // echo $form->field($model, 'parent_id') ?>

		<?php // echo $form->field($model, 'priority') ?>

		<?php // echo $form->field($model, 'aksses__ids') ?>

		<?php // echo $form->field($model, 'text_advice') ?>

		<?php // echo $form->field($model, 'descr') ?>

		<?php // echo $form->field($model, 'image_catalog') ?>

		<?php // echo $form->field($model, 'image_menu') ?>

		<?php // echo $form->field($model, 'video') ?>

		<?php // echo $form->field($model, 'disallow_xml') ?>

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
