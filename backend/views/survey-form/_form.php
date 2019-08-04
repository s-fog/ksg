<?php

use common\models\Step;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var common\models\SurveyForm $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="survey-form-form">

    <?php $form = ActiveForm::begin([
            'id' => 'SurveyForm',
        ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>
        <br>

        <div>
            <p>Опрос: <?=$model->survey->name?></p>

            <!-- attribute email -->
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <!-- attribute phone -->
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            <?php
            $options = json_decode($model->options, true)[$model->survey->id];
            $steps = Step::find()
                ->where(['survey_id' => $model->survey->id])
                ->with(['stepOptions' => function($q) {
                    $q->indexBy('id');
                }])
                ->indexBy('id')
                ->all();
            ?>
            <h4>Выбранные опции</h4>
            <table class="table table-striped table-bordered detail-view">
                <?php foreach($options as $step_id => $opts) {
                    $names = [];
                    ?>
                    <tr>
                        <td><?=$steps[$step_id]->name?></td>
                        <?php foreach($opts as $stepOptionId) {
                            $names[] = $steps[$step_id]['stepOptions'][$stepOptionId]->name;
                        }?>
                        <td><?=implode(', ', $names)?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php $this->endBlock(); ?>

        <?=
        Tabs::widget(
            [
                'encodeLabels' => false,
                'items' => [
                    [
                        'label'   => Yii::t('models', 'SurveyForm'),
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

