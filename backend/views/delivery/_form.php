<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Delivery $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="Delivery-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Delivery',
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
            

			<?= $form->field($model, 'gte')->textInput() ?>
			<?= $form->field($model, 'lt')->textInput() ?>
			<?= $form->field($model, 'moscow_price')->textInput() ?>
			<?= $form->field($model, 'other_price')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Delivery'),
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

