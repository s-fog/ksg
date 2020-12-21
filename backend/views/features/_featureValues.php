<?php

use kidzen\dynamicform\DynamicFormWidget;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;

?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner_fv',
    'widgetBody' => '.container-fv',
    'widgetItem' => '.fv-item',
    'min' => 0,
    'insertButton' => '.add-fv',
    'deleteButton' => '.remove-fv',
    'model' => $modelsFeatureValue[0],
    'formId' => $formId,
    'formFields' => [
        'name',
        'value',
    ],
]);?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Название</th>
        <th>Значение</th>
        <th class="text-center">
            <button type="button" class="add-fv btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
        </th>
    </tr>
    </thead>
    <tbody class="container-fv">
    <?php foreach ($modelsFeatureValue as $indexFeatureValue => $modelFeatureValue): ?>
        <tr class="fv-item" data-id="<?=$modelFeatureValue->id?>">
            <td class="vcenter">
                <?php
                // necessary for update action.
                if (! $modelFeatureValue->isNewRecord) {
                    echo Html::activeHiddenInput($modelFeatureValue, "[{$indexFeature}][{$indexFeatureValue}]id");
                }
                ?>
                <?= $form->field($modelFeatureValue, "[{$indexFeature}][{$indexFeatureValue}]name")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
            <td class="vcenter">
                <?= $form->field($modelFeatureValue, "[{$indexFeature}][{$indexFeatureValue}]value")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
            <?php if ($formId === 'Category') { ?>
                <td class="vcenter">
                    <?= $form->field($modelFeatureValue, "[{$indexFeature}][{$indexFeatureValue}]main_param")->checkbox() ?>
                </td>
            <?php } ?>
            <td class="text-center vcenter" style="width: 90px;">
                <button type="button" class="remove-fv btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>
