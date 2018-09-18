<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var common\models\NewsSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'alias') ?>

		<?= $form->field($model, 'created_at') ?>

		<?= $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'seo_h1') ?>

		<?php // echo $form->field($model, 'seo_title') ?>

		<?php // echo $form->field($model, 'seo_keywords') ?>

		<?php // echo $form->field($model, 'seo_description') ?>

		<?php // echo $form->field($model, 'sort_order') ?>

		<?php // echo $form->field($model, 'html') ?>

		<?php // echo $form->field($model, 'html2') ?>

		<?php // echo $form->field($model, 'image') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
