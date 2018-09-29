<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('models', 'Загрузка Xlsx');
?>
<div class="supplier-form">

    <?php  $form = ActiveForm::begin([
            'id' => 'Simple',
        ]
    );
    ?>

    <div class="">
        <?php
            if ($success !== false) {
                echo 'Прошло '.$success.' транзакций';
            } else {
                echo 'Что-то пошло не так';
            }
        ?>
        <?= $form->field($model, 'file')->fileInput() ?>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            'Загрузить',
            [
                'id' => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

