<?php
use common\models\Param;
use kartik\widgets\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;

DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_steps', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-steps', // required: css class selector
    'widgetItem' => '.steps-item', // required: css class
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-steps', // css class
    'deleteButton' => '.remove-steps', // css class
    'model' => $modelsStep[0],
    'formId' => 'Survey',
    'formFields' => [
        'name',
        'text',
        'icon',
        'options',
    ]
]); ?>

    <div class="panel panel-default">
        <div class="panel-heading" style="height: 45px;">
            <h4 style="float: left;margin: 0;"><i class="glyphicon glyphicon-envelope"></i> Шаги</h4>
            <div class="pull-right">
                <button type="button" class="add-steps btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
        </div>
        <div class="panel-body">
            <div class="container-steps"><!-- widgetContainer -->
                <?php foreach ($modelsStep as $i => $modelParams): ?>
                    <div class="steps-item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Шаг</h3>
                            <div class="pull-right">
                                <button type="button" class="remove-steps btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                                if (! $modelParams->isNewRecord) {
                                    echo Html::activeHiddenInput($modelParams, "[{$i}]id");
                                }
                            ?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <?= $form->field($modelParams, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-xs-6">
                                    <?= $form->field($modelParams, "[{$i}]sort_order")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <?= $form->field($modelParams, "[{$i}]text")->textarea(['maxlength' => true]) ?>
                                </div>
                                <div class="col-xs-6">
                                    <?= $form->field($modelParams, "[{$i}]icon")->textarea(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <?= $form->field($modelParams, "[{$i}]inner_header")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="col-xs-6">
                                    <?= $form->field($modelParams, "[{$i}]inner_text")->textarea(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <h3>Опции</h3>
                            <?php if (!empty($modelsStep[$i])) { ?>
                                <?= $this->render('@backend/views/survey/_stepOptions', [
                                    'form' => $form,
                                    'indexStep' => $i,
                                    'modelsStepOption' => $modelsStepOption[$i],
                                ]) ?>
                            <?php } ?>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="panel-heading" style="height: 45px;padding: 10px 0 0 0;">
                <div class="pull-right">
                    <button type="button" class="add-steps btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
<?php DynamicFormWidget::end(); ?>