<?php

use common\models\FilterFeature;
use common\models\FilterFeatureValue;
use common\models\ProductHasFilterFeatureValue;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

$filterFeatures = FilterFeature::find()
    ->where(['category_id' => $model->parent_id])
    ->orderBy(['sort_order' => SORT_ASC])
    ->all();

?>

<?php foreach($filterFeatures as $index => $filterFeature) { ?>
    <section class="col-lg-7">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title"><?=$filterFeature->name?></h3>
                <input type="hidden" name="<?=$form->id?>[FilterFeature][<?=$index?>][id]" value="<?=$filterFeature->id?>">
            </div>
            <div class="box-body">
                <?php
                $data = [];
                $a1 = ProductHasFilterFeatureValue::findAll(['product_id' => $model->id]);
                $a2 = FilterFeatureValue::find()
                    ->where([
                        'id' => ArrayHelper::map($a1, 'filter_feature_value_id', 'filter_feature_value_id'),
                        'filter_feature_id' => $filterFeature->id,
                    ])
                    ->orderBy(['name' => SORT_ASC])
                    ->all();
                $a3 = FilterFeatureValue::find()
                    ->where([
                        'filter_feature_id' => $filterFeature->id,
                    ])
                    ->orderBy(['name' => SORT_ASC])
                    ->all();
                $initial = ArrayHelper::map($a2, 'name', 'name');
                $data = ArrayHelper::map($a3, 'name', 'name');

                echo Select2::widget([
                    'name' => "{$form->id}[FilterFeature][$index][values]",
                    'value' => $initial, // initial value
                    'data' => $data,
                    'maintainOrder' => true,
                    'options' => [
                        'placeholder' => 'Выберите значения',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'tags' => true
                    ],
                ]);
                ?>
            </div>
        </div>
    </section>
<?php } ?>

