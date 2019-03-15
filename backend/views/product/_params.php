<?php
use common\models\Param;
use kartik\checkbox\CheckboxX;
use kartik\file\FileInput;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;

?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_params', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-params', // required: css class selector
    'widgetItem' => '.params-item', // required: css class
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-params', // css class
    'deleteButton' => '.remove-params', // css class
    'model' => $modelsParams[0],
    'formId' => 'Product',
    'formFields' => [
        'artikul',
        'available',
        'params',
        'image_number',
    ]
]); ?>

    <div class="panel panel-default">
        <div class="panel-heading" style="height: 45px;">
            <h4 style="float: left;margin: 0;"><i class="glyphicon glyphicon-envelope"></i> Варианты</h4>
            <div class="pull-right">
                <button type="button" class="add-params btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
        </div>
        <div class="panel-body">
            <div class="container-params"><!-- widgetContainer -->
                <?php foreach ($modelsParams as $i => $modelParams): ?>
                    <div class="params-item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Вариант</h3>
                            <div class="pull-right">
                                <button type="button" class="remove-params btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                                if (! $modelParams->isNewRecord) {
                                    echo Html::activeHiddenInput($modelParams, "[{$i}]id");

                                    if ($modelParams->available > 0) {
                                        $modelParams->available = 10;
                                    }
                                }
                            ?>

                            <?= $form->field($modelParams, "[{$i}]artikul")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelParams, "[{$i}]available")->dropDownList([
                                0 => 0,
                                10 => 10,
                            ]) ?>
                            <?= $form->field($modelParams, "[{$i}]image_number")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelParams, "[{$i}]params")->widget(Select2::classname(), [
                                'data' => Param::getList(),
                                'options' => ['placeholder' => 'Варианты', 'multiple' => true],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'tokenSeparators' => [',', ''],
                                    'maximumInputLength' => 100
                                ],
                            ]) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="panel-heading" style="height: 45px;padding: 10px 0 0 0;">
                <div class="pull-right">
                    <button type="button" class="add-params btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
<?php DynamicFormWidget::end(); ?>

<?php
$script = <<< JS
    $(function () {
        $(".dynamicform_wrapper_params").on("afterInsert", function(e, item) {
            var index = $(item).index();
            
            $('#productparam-'+index+'-available').val(0);
            $('#productparam-'+index+'-image_number').val(0);
        });
    });
JS;
$this->registerJs($script);
?>
