
<br>
<!-- attribute seo_h1 -->
<?= $form->field($model, 'seo_h1')->textInput(['maxlength' => true]) ?>

<!-- attribute seo_title -->
<?= $form->field($model, 'seo_title')->textInput(['maxlength' => true]) ?>

<!-- attribute seo_description -->
<?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>

<!-- attribute seo_keywords -->
<?= $form->field($model, 'seo_keywords')->textInput(['maxlength' => true]) ?>