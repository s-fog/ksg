<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Changer $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="changer-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Changer',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-danger',
    'fieldConfig' => [
    'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
    'horizontalCssClasses' => [
    'label' => 'col-sm-2',
    #'offset' => 'col-sm-offset-4',
    'wrapper' => 'col-sm-8',
    'error' => '',
    'hint' => '',
    ],
    ],
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute product_id -->
			<?= $form->field($model, 'product_id')->textInput() ?>

<!-- attribute supplier_id -->
			<?= $form->field($model, 'supplier_id')->textInput() ?>

<!-- attribute brand_id -->
			<?= $form->field($model, 'brand_id')->textInput() ?>

<!-- attribute old_price -->
			<?= $form->field($model, 'old_price')->textInput() ?>

<!-- attribute new_price -->
			<?= $form->field($model, 'new_price')->textInput() ?>

<!-- attribute percent -->
			<?= $form->field($model, 'percent')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Changer'),
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

