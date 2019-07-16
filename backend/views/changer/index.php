<?php

use common\models\base\ChangerForm;
use common\models\Brand;
use common\models\Product;
use common\models\Supplier;
use kartik\widgets\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\ChangerSearch $searchModel
 */

$this->title = 'Изменения цен';
$suppliers[0] = 'Все';
$brands[0] = 'Все';

foreach(Supplier::find()->orderBy('name')->all() as $item) {
    $suppliers[$item->id] = $item->name;
}

foreach(Brand::find()->orderBy('name')->all() as $item) {
    $brands[$item->id] = $item->name;
}
$form = new \yii\widgets\ActiveForm();
$form->begin();
?>
<div class="row">
    <div class="col-sm-3">
        <?=$form->field($changerForm, 'supplier_id')->widget(Select2::classname(), [
            'data' => $suppliers,
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])?>
    </div>
    <div class="col-sm-3">
        <?=$form->field($changerForm, 'brand_id')->widget(Select2::classname(), [
            'data' => $brands,
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])?>
    </div>
    <div class="col-sm-2">
        <?=$form->field($changerForm, 'price_from')->textInput()?>
    </div>
    <div class="col-sm-2">
        <?=$form->field($changerForm, 'price_to')->textInput()?>
    </div>
    <div class="col-sm-2">
        <?=$form->field($changerForm, 'percent')->textInput()?>
    </div>
</div>
<button type="submit" class="btn btn-primary">Понеслась</button>
<?php
$form->end();
if ($changerForm->count > 0) {
    echo '<p style="font-weight: bold;font-size: 1.2em;">Было изменение следующее кол-во товаров - '.$changerForm->count.' шт.</p>';
}
?>
<div class="giiant-crud changer-index">
    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel' => 'Last',
            ],
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class'=>'x'],
            'columns' => [
                [
                    'attribute' => 'product_id',
                    'content' => function($data) {
                        if (!empty($data->product)) {
                            return $data->product->name;
                        } else {
                            return '<span style="color: red;">Этот товар был удален</span>';
                        }
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'product_id',
                        'data' => ArrayHelper::map(Product::find()->orderBy('name')->all(), 'id', 'name'),
                        'options' => [
                            'placeholder' => 'Начните набирать ...',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
                [
                    'attribute' => 'supplier_id',
                    'content' => function($data) {
                        if (!empty($data->supplier)) {
                            return $data->supplier->name;
                        } else {
                            return '<span style="color: red;">Этот поставщик был удален</span>';
                        }
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'supplier_id',
                        'data' => ArrayHelper::map(Supplier::find()->orderBy('name')->all(), 'id', 'name'),
                        'options' => [
                            'placeholder' => 'Начните набирать ...',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
                [
                    'attribute' => 'brand_id',
                    'content' => function($data) {
                        if (!empty($data->brand)) {
                            return $data->brand->name;
                        } else {
                            return '<span style="color: red;">Этот бренд был удален</span>';
                        }
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'brand_id',
                        'data' => ArrayHelper::map(Brand::find()->orderBy('name')->all(), 'id', 'name'),
                        'options' => [
                            'placeholder' => 'Начните набирать ...',
                            'multiple' => false,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
                'old_price',
                'new_price',
                'percent',
            ],
        ]); ?>

    </div>
</div>
