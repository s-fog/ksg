<?php

use common\models\Category;
use kartik\widgets\Select2;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Build $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="build-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Build',
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
            <?php
            $model->prices = json_decode($model->prices, true);
            ?>
            <?= $form->field($model, 'prices')->widget(MultipleInput::className(), [
                'min' => 1,
                'columns' => [
                    [
                        'name'  => 'min_price',
                        'title' => 'Цена от',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
                    [
                        'name'  => 'max_price',
                        'title' => 'Цена до',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
                    [
                        'name'  => 'price',
                        'title' => 'Цена',
                        'enableError' => true,
                        'options' => [
                            'class' => 'input-priority'
                        ]
                    ],
                ]
            ]);
            ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Build'),
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

