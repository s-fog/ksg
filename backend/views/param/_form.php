<?php

use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var common\models\Param $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="param-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Param',
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute name -->
			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

<!-- attribute variants -->
			<?php
                if (!empty($model->variants)) {
                    $model->variants = explode(',', $model->variants);

                    foreach($model->variants as $item) {
                        $vars[$item] = $item;
                    }
                } else {
                    $vars = [];
                }
            echo $form->field($model, 'variants')->widget(Select2::classname(), [
                'data' => $vars,
                'options' => ['placeholder' => 'Варианты', 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                    'tokenSeparators' => [',', ''],
                    'maximumInputLength' => 100
                ],
            ]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Param'),
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

