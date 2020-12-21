<?php
use common\models\Adviser;
use common\models\Brand;
use common\models\Category;
use common\models\Currency;
use common\models\Product;
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

<?php
$model->setBrothersIds();
$products = ArrayHelper::map(Product::find()
    ->select(['id', 'name'])
    ->where(['!=', 'id', $model->id])
    ->orderBy(['name' => SORT_ASC])
    ->asArray()
    ->all(), 'id', 'name');

echo $form->field($model, 'brothers_ids')->widget(Select2::classname(), [
    'data' => $products,
    'options' => [
            'multiple' => true
    ]
])->label('Братья');
?>

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
<?= $form->field($model, 'mmodel')->textInput() ?>

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

<?=$this->render('@backend/views/features/_sortableJs')?>