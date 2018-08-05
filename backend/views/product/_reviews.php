<?php
use kartik\checkbox\CheckboxX;
use kartik\file\FileInput;
use kartik\widgets\DatePicker;
use unclead\multipleinput\MultipleInput;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

?>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper_reviews', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-reviews', // required: css class selector
            'widgetItem' => '.reviews-item', // required: css class
            'min' => 0, // 0 or 1 (default 1)
            'insertButton' => '.add-reviews', // css class
            'deleteButton' => '.remove-reviews', // css class
            'model' => $modelsReview[0],
            'formId' => 'Product',
            'formFields' => [
                'name',
                'text',
                'date',
                'active',
            ],
        ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading" style="height: 45px;">
            <h4 style="float: left;margin: 0;"><i class="glyphicon glyphicon-envelope"></i> Отзывы</h4>
            <div class="pull-right">
                <button type="button" class="add-reviews btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
            </div>
        </div>
        <div class="panel-body">
            <div class="container-reviews"><!-- widgetContainer -->
                <?php foreach ($modelsReview as $i => $modelReview): ?>
                    <div class="reviews-item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <h3 class="panel-title pull-left">Отзыв</h3>
                            <div class="pull-right">
                                <button type="button" class="remove-reviews btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                                if (! $modelReview->isNewRecord) {
                                    echo Html::activeHiddenInput($modelReview, "[{$i}]id");
                                } else {
                                    $modelReview->active = 0;
                                }
                            ?>

                            <?= $form->field($modelReview, "[{$i}]name")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelReview, "[{$i}]text")->textInput(['maxlength' => true]) ?>
                            <?= $form->field($modelReview, "[{$i}]date")->widget(DatePicker::classname(), [
                                'options' => ['placeholder' => 'Дата'],
                                'pluginOptions' => [
                                    'format' => 'dd.mm.yyyy',
                                    'autoclose' => true,
                                    'todayHighlight' => false
                                ]
                            ]);?>
                            <?= $form->field($modelReview, "[{$i}]active")->widget(CheckboxX::classname(), [
                                'pluginOptions' => [
                                    'threeState'=>false
                                ]
                            ])?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="panel-heading" style="height: 45px;padding: 10px 0 0 0;">
                <div class="pull-right">
                    <button type="button" class="add-reviews btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
<?php DynamicFormWidget::end(); ?>

<?php
$script = <<< JS
    $(function () {
        $(".dynamicform_wrapper_reviews").on("afterInsert", function(e, item) {
            var index = $(item).index();
            
            $('#productreview-'+index+'-date').kvDatepicker({
                                format: 'dd.mm.yyyy',
                                language: 'ru',
                                autoclose: true,
                                todayHighlight: false
            });
            
            $('#productreview-'+index+'-active').checkboxX({
                threeState: false
            });
        });
    });
JS;
$this->registerJs($script);
?>
