<?php

use kidzen\dynamicform\DynamicFormWidget;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;

?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner_so',
    'widgetBody' => '.container-so',
    'widgetItem' => '.so-item',
    'min' => 0,
    'insertButton' => '.add-so',
    'deleteButton' => '.remove-so',
    'model' => $modelsStepOption[0],
    'formId' => 'Survey',
    'formFields' => [
        'name',
        'sort_order',
    ],
]); ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Название</th>
            <th>Сортировка</th>
            <th class="text-center">
                <button type="button" class="add-so btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
    </thead>
    <tbody class="container-so">
    <?php foreach ($modelsStepOption as $indexStepOption => $modelStepOption): ?>
        <tr class="so-item" data-id="<?=$modelStepOption->id?>">
            <td class="vcenter">
                <?php
                // necessary for update action.
                if (! $modelStepOption->isNewRecord) {
                    echo Html::activeHiddenInput($modelStepOption, "[{$indexStep}][{$indexStepOption}]id");
                }
                ?>
                <?= $form->field($modelStepOption, "[{$indexStep}][{$indexStepOption}]name")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
            <td class="vcenter">
                <?= $form->field($modelStepOption, "[{$indexStep}][{$indexStepOption}]sort_order")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
            <td class="text-center vcenter" style="width: 90px;">
                <button type="button" class="remove-so btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>
