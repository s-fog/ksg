<?php
use common\models\Adviser;
use common\models\Brand;
use common\models\Category;
use common\models\Currency;
use common\models\ProductHasCategory;
use common\models\Supplier;
use kartik\checkbox\CheckboxX;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use mihaildev\ckeditor\CKEditor;
use unclead\multipleinput\MultipleInput;
use yii\helpers\ArrayHelper;

?>
<br>
<!-- attribute name -->
<?=$form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!-- attribute alias -->
<?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

<?php
$parents = Category::getCategoryChain();
echo $form->field($model, 'parent_id')->widget(Select2::classname(), [
    'data' => $parents
]);
?>

<?php if (!$model->isNewRecord) { ?>
    <div class="form-group">
        <label class="control-label">Другие категории</label>
        <?php
        echo Select2::widget([
            'name' => 'categories_ids',
            'value' => ProductHasCategory::getValues($model->id), // initial value
            'data' => Category::getList(),
            'maintainOrder' => true,
            'options' => ['placeholder' => 'Выберите категории', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 100,
                'class' => 'difCats'
            ],
            'pluginEvents' => [
                "change" => "function(event) { 
                        var values = $(this).val();
                        var request = 'values=' + values + '&product_id=' + ".$model->id.";
                        console.log(values);
                                            
                        $.post('/officeback/ajax/product-has-category-change', request, function(response) {
                            console.log(response);
                        });
                    }",
            ]
        ]);
        ?>
    </div>
<?php } else {?>
    <div class="form-group">
        <label class="control-label">Другие категории</label>
        <label class="control-label" style="color: red;">Другие категории станут доступны после сохранения товара</label>
    </div>
<?php } ?>

<?php
echo '<br>';
echo $this->render('@backend/views/features/_features', [
    'form' => $form,
    'modelsFeature' => $modelsFeature,
    'modelsFeatureValue' => $modelsFeatureValue,
    'formId' => 'Product'
]);
echo '<br>';
?>


<!-- attribute brand_id -->
<?php
$brands[''] = 'Ничего не выбрано';
foreach(ArrayHelper::map(Brand::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name') as $id => $name) {
    $brands[$id] = $name;
}
?>
<?= $form->field($model, 'mmodel')->dropDownList($brands) ?>

<?= $form->field($model, 'brand_id')->dropDownList($brands) ?>

<!-- attribute supplier -->
<?php
$suppliers[''] = 'Ничего не выбрано';
foreach(ArrayHelper::map(Supplier::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name') as $id => $name) {
    $suppliers[$id] = $name;
}
?>
<?= $form->field($model, 'supplier')->dropDownList($suppliers) ?>

<!-- attribute price -->
<?= $form->field($model, 'price')->textInput() ?>

<!-- attribute price_old -->
<?= $form->field($model, 'price_old')->textInput() ?>

<?= $form->field($model, 'currency_id')->dropDownList(
    ArrayHelper::map(Currency::find()->orderBy(['name' => SORT_ASC])->all(), 'id', 'name')
) ?>
<!-- attribute description -->
<?= $form->field($model, 'description')->widget(CKEditor::className()) ?>

<?= $form->field($model, 'disallow_xml')->widget(CheckboxX::classname(), [
    'pluginOptions' => [
        'threeState'=>false
    ]
]) ?>

<?= $form->field($model, 'hit')->widget(CheckboxX::classname(), [
    'pluginOptions' => [
        'threeState'=>false
    ]
]) ?>

<?php

$advisers = ['' => 'Ничего не выбрано'];

foreach(Adviser::find()->orderBy(['name' => SORT_ASC])->all() as $tt) {
    $advisers[$tt->id] = $tt->name;
}

?>

<?= $form->field($model, 'adviser_id')->dropDownList($advisers) ?>
<!-- attribute adviser_text -->
<?= $form->field($model, 'adviser_text')->textarea(['rows' => 6]) ?>

<!-- attribute code -->
<?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

<div style="border: 1px solid #000;border-radius: 10px;padding: 10px;">
<?php
if ($model->instruction) {
    echo '
    <div class="form-group">
        <div>'.$model->instruction.'</div>
    </div>
    ';
    }

    echo $form->field($model, 'instruction')->widget(FileInput::className(), [
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i>',
            'browseLabel' =>  'Выберите файл'
        ]
    ]);
    ?>
</div>
<br>

<!-- attribute video -->
<?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>

<?=$this->render('@backend/views/blocks/image', [
    'form' => $form,
    'model' => $model,
    'image' => $model->present_image,
    'name' => 'present_image'
])?>

<?=$this->render('@backend/views/features/_sortableJs')?>