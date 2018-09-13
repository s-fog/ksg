<?php

use common\models\Category;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Waranty $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="waranty-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Waranty',
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

            <?php
            $array = Category::getCategoryChain3rdLevel();

            echo $form->field($model, 'category_id')->widget(Select2::classname(), [
                'data' => $array
            ]);
            ?>

            <!-- attribute text -->
            <?= $form->field($model, 'text')->widget(\mihaildev\ckeditor\CKEditor::className()) ?>

            <!-- attribute price -->
            <?= $form->field($model, 'price')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Waranty'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? 'Создать' : 'Сохранить'),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

