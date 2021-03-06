<?php

use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

?>
<h3>Характеристики</h3>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_features', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-features', // required: css class selector
    'widgetItem' => '.features-item', // required: css class
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-features', // css class
    'deleteButton' => '.remove-features', // css class
    'model' => $modelsFeature[0],
    'formId' => $formId,
    'formFields' => [
        'header',
        'sort_order',
    ],
]); ?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Заголовок</th>
            <th style="width: 450px;">Значения</th>
            <th class="text-center" style="width: 90px;">
                <button type="button" class="add-features btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-features">
        <?php foreach ($modelsFeature as $indexFeature => $modelFeature): ?>
            <tr class="features-item" data-id="<?=$modelFeature->id?>">
                <td class="vcenter" style="width: 25%;">
                    <?php
                    // necessary for update action.
                    if (! $modelFeature->isNewRecord) {
                        echo Html::activeHiddenInput($modelFeature, "[{$indexFeature}]id");
                    }
                    ?>
                    <?= $form->field($modelFeature, "[{$indexFeature}]header")->label(false)->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelFeature, "[{$indexFeature}]sort_order")->label('Порядок сортировки')->textInput(['maxlength' => true]) ?>
                </td>
                <td style="width: 75%;">
                    <?php if (!empty($modelsFeatureValue[$indexFeature])) { ?>
                    <?= $this->render('@backend/views/features/_featureValues', [
                        'form' => $form,
                        'indexFeature' => $indexFeature,
                        'modelsFeatureValue' => $modelsFeatureValue[$indexFeature],
                        'formId' => $formId,
                    ]) ?>
                    <?php } ?>
                </td>
                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-features btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>
