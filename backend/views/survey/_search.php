<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var common\models\SurveySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="survey-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'created_at') ?>

		<?= $form->field($model, 'updated_at') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'alias') ?>

		<?php // echo $form->field($model, 'seo_h1') ?>

		<?php // echo $form->field($model, 'seo_title') ?>

		<?php // echo $form->field($model, 'seo_description') ?>

		<?php // echo $form->field($model, 'under_header') ?>

		<?php // echo $form->field($model, 'youtube') ?>

		<?php // echo $form->field($model, 'youtube_text') ?>

		<?php // echo $form->field($model, 'button_text') ?>

		<?php // echo $form->field($model, 'button2_text') ?>

		<?php // echo $form->field($model, 'cupon_header') ?>

		<?php // echo $form->field($model, 'cupon_text') ?>

		<?php // echo $form->field($model, 'cupon_image') ?>

		<?php // echo $form->field($model, 'cupon_button') ?>

		<?php // echo $form->field($model, 'preview_image') ?>

		<?php // echo $form->field($model, 'introtext') ?>

		<?php // echo $form->field($model, 'success_header') ?>

		<?php // echo $form->field($model, 'success_image') ?>

		<?php // echo $form->field($model, 'success_button') ?>

		<?php // echo $form->field($model, 'success_text') ?>

		<?php // echo $form->field($model, 'success_link_text') ?>

		<?php // echo $form->field($model, 'success_link') ?>

		<?php // echo $form->field($model, 'step_header') ?>

		<?php // echo $form->field($model, 'sort_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
