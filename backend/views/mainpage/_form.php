<?php

use common\models\Performance;
use kartik\widgets\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Mainpage $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="mainpage-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Mainpage',
    ]
    );
    ?>
    <?=$form->field($model, 'delivery')->textarea(['maxlength' => true]) ?>
    <?=$form->field($model, 'product_delivery_left')->widget(CKEditor::className()) ?>
    <?=$form->field($model, 'product_delivery_right')->widget(CKEditor::className()) ?>
    <?php
        echo '<div style="margin: 15px 0;border: 1px solid #000;border-radius: 10px;padding: 10px;">';
        if ($model->banner_image) {
            echo Html::img($model->banner_image, ['width' => 250]).'<br><br>';
        }

        echo $form->field($model, 'banner_image')->widget(FileInput::className(), [
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i>',
                'browseLabel' =>  'Выберите изображение'
            ],
            'options' => ['accept' => 'image/*']
        ]);
        ?>
    </div>

    <?=$form->field($model, 'delivery_free_from') ?>
    <?=$form->field($model, 'seo_title') ?>
    <?=$form->field($model, 'seo_keywords') ?>
    <?=$form->field($model, 'seo_description') ?>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Create' : 'Сохранить'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

