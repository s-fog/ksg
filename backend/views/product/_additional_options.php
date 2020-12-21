<?php

use common\models\Adviser;
use kartik\checkbox\CheckboxX;
use kartik\widgets\FileInput;

?>
    <br>

<?= $form->field($model, 'disallow_xml')->widget(CheckboxX::classname(), [
    'pluginOptions' => [
        'threeState'=>false
    ]
]) ?>

<?= $form->field($model, 'hit')->widget(CheckboxX::classname(), [
    'pluginOptions' => [
        'threeState'=>false
    ]
]) ?>

<?php

$advisers = ['' => 'Ничего не выбрано'];

foreach(Adviser::find()->orderBy(['name' => SORT_ASC])->all() as $tt) {
    $advisers[$tt->id] = $tt->name;
}

?>

<?= $form->field($model, 'adviser_id')->dropDownList($advisers) ?>
<!-- attribute adviser_text -->
<?= $form->field($model, 'adviser_text')->textarea(['rows' => 6]) ?>

<!-- attribute code -->
<?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

<div style="border: 1px solid #000;border-radius: 10px;padding: 10px;">
    <?php
    if ($model->instruction) {
        echo '
    <div class="form-group">
        <div>'.$model->instruction.'</div>
    </div>
    ';
    }

    echo $form->field($model, 'instruction')->widget(FileInput::className(), [
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i>',
            'browseLabel' =>  'Выберите файл'
        ]
    ]);
    ?>
</div>
<br>

<!-- attribute video -->
<?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>

<?=$this->render('@backend/views/blocks/image', [
    'form' => $form,
    'model' => $model,
    'image' => $model->present_image,
    'name' => 'present_image'
])?>