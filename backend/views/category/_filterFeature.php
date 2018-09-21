<?php

use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

?>
<h3>Характеристики для фильтра</h3>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_filterFeatures', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-filterFeatures', // required: css class selector
    'widgetItem' => '.filterFeatures-item', // required: css class
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-filterFeatures', // css class
    'deleteButton' => '.remove-filterFeatures', // css class
    'model' => $modelsFilterFeature[0],
    'formId' => $formId,
    'formFields' => [
        'name',
        'sort_order',
    ],
]); ?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th></th>
            <th class="text-center" style="width: 90px;">
                <button type="button" class="add-filterFeatures btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-filterFeatures">
        <?php foreach ($modelsFilterFeature as $indexFilterFeature => $modelFilterFeature): ?>
            <tr class="filterFeatures-item" data-id="<?=$modelFilterFeature->id?>">
                <td>
                    <?php
                    // necessary for update action.
                    if (! $modelFilterFeature->isNewRecord) {
                        echo Html::activeHiddenInput($modelFilterFeature, "[{$indexFilterFeature}]id");
                    }
                    ?>
                    <?= $form->field($modelFilterFeature, "[{$indexFilterFeature}]name")->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelFilterFeature, "[{$indexFilterFeature}]sort_order")->label('Порядок сортировки')->textInput(['maxlength' => true]) ?>
                </td>

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-filterFeatures btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>
