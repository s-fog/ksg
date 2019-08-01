<br>
<!-- attribute name -->
<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!-- attribute alias -->
<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

<?=$this->render('@backend/views/blocks/image', [
    'form' => $form,
    'model' => $model,
    'image' => $model->preview_image,
    'name' => 'preview_image'
])?>
<!-- attribute introtext -->
<?= $form->field($model, 'introtext')->textarea(['rows' => 6]) ?>

<!-- attribute under_header -->
<?= $form->field($model, 'under_header')->textarea(['rows' => 6]) ?>

<!-- attribute youtube_text -->
<?= $form->field($model, 'youtube_text')->textarea(['rows' => 6]) ?>

<!-- attribute youtube -->
<?= $form->field($model, 'youtube')->textInput(['maxlength' => true]) ?>

<!-- attribute button_text -->
<?= $form->field($model, 'button_text')->textInput(['maxlength' => true]) ?>

<!-- attribute button2_text -->
<?= $form->field($model, 'button2_text')->textInput(['maxlength' => true]) ?>

<!-- attribute cupon_header -->
<?= $form->field($model, 'cupon_header')->textInput(['maxlength' => true]) ?>
<!-- attribute cupon_text -->
<?= $form->field($model, 'cupon_text')->textarea(['rows' => 6]) ?>

<?=$this->render('@backend/views/blocks/image', [
    'form' => $form,
    'model' => $model,
    'image' => $model->cupon_image,
    'name' => 'cupon_image'
])?>

<!-- attribute cupon_button -->
<?= $form->field($model, 'cupon_button')->textInput(['maxlength' => true]) ?>

<!-- attribute success_header -->
<?= $form->field($model, 'success_header')->textInput(['maxlength' => true]) ?>


<?=$this->render('@backend/views/blocks/image', [
    'form' => $form,
    'model' => $model,
    'image' => $model->success_image,
    'name' => 'success_image'
])?>


<!-- attribute success_text -->
<?= $form->field($model, 'success_text')->textarea(['rows' => 6]) ?>

<!-- attribute success_link -->
<?= $form->field($model, 'success_link')->textarea(['rows' => 6]) ?>
<!-- attribute success_button -->
<?= $form->field($model, 'success_button')->textInput(['maxlength' => true]) ?>

<!-- attribute success_link_text -->
<?= $form->field($model, 'success_link_text')->textInput(['maxlength' => true]) ?>

<!-- attribute step_header -->
<?= $form->field($model, 'step_header')->textInput(['maxlength' => true]) ?>