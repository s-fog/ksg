<?php

use common\models\Image;
use common\models\ProductParam;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var common\models\OrderSearch $searchModel
*/

$this->title = Yii::t('models', 'Orders');

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'New', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{update}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud order-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', 'Orders') ?>
    </h1>

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
            'class' => 'yii\grid\ActionColumn',
            'template' => $actionColumnTemplateString,
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'View'),
                        'aria-label' => Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
                }
            ],
            'urlCreator' => function($action, $model, $key, $index) {
                // using the column name as key, not mapping to 'id' like the standard generator
                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                return Url::toRoute($params);
            },
            'contentOptions' => ['nowrap'=>'nowrap']
        ],
            'id',
            [
                'attribute'=>'created_at',
                'format'=>'text',
                'content'=>function($data){
                    return date('d.m.Y H:i', $data->created_at);
                }
            ],
            [
                'attribute'=>'total_cost',
                'format'=>'text',
                'label'=>'Обшая сумма со скидкой',
                'content'=>function($data){
                    return number_format($data->costWithDiscount(), 0, '', ' ').' <span class="rubl">P</span>';
                }
            ],
            [
                'attribute'=>'payment',
                'label'=>'Способ оплаты',
                'format'=>'text',
                'content'=>function($data) {
                    foreach(Yii::$app->params['payments'] as $id => $name) {
                        if ($id == $data->payment) {
                            return $name;
                        }
                    }
                },
                'filter' => Yii::$app->params['payments']
            ],
            [
                'attribute'=>'paid',
                'label'=>'Оплачен?',
                'format'=>'text',
                'content'=>function($data){
                    if (!empty($data->paid)) {
                        return "<div style='text-align: center;'><img src='/img/icon_02.png' alt=''></div>";
                    } else {
                        return "<div style='text-align: center;'><img src='/img/icon_01.png' alt=''></div>";
                    }
                },
                'filter' => [
                    '0' => 'Не Оплачен',
                    '1' => 'Оплачен'
                ]
            ],
            [
                'attribute'=>'status',
                'label'=>'Статус',
                'format'=>'text',
                'content'=>function($data){
                    foreach(Yii::$app->params['orderStatuses'] as $id => $name) {
                        if ($id == $data->status) {
                            return $name;
                        }
                    }
                },
                'filter' => Yii::$app->params['orderStatuses']
            ],
            [
                'attribute' => 'products',
                'label' => 'Товары',
                'format' => 'html',
                'content' => function($data){
                    $products = unserialize(base64_decode($data->products));
                    $maxCostProduct = '';
                    $maxCost = '0';
                    $fullQuantity = 0;

                    foreach($products as $product) {
                        if ($product->price > $maxCost) {
                            $maxCost = $product->price;
                            $maxCostProduct = $product;
                        }

                        $quantity = $product->getQuantity();
                        $fullQuantity += $quantity;
                    }

                    if (!empty($maxCostProduct)) {
                        return $maxCostProduct->name.' + '.($fullQuantity-1);
                    } else {
                        return 0;
                    }

                }
            ],
            [
                'attribute'=>'big_image',
                'label'=>'Изображение',
                'format'=>'html',
                'content'=>function($data){
                    $products = unserialize(base64_decode($data->products));
                    $maxCostProduct = '';
                    $maxCost = '0';

                    foreach($products as $product) {
                        if ($product->price > $maxCost) {
                            $maxCost = $product->price;
                            $maxCostProduct = $product;
                        }
                    }

                    if (!empty($maxCostProduct)) {
                        $productParam = ProductParam::findOne([
                            'product_id' => $maxCostProduct->id,
                            'params' => $maxCostProduct->paramsV
                        ]);
                        $image = Image::find()
                            ->where(['product_id' => $maxCostProduct->id])
                            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
                            ->offset($productParam->image_number)
                            ->one();

                        return '<img src="'.$image->image.'" style="width: 50px;">';
                    } else {
                        return '';
                    }
                }
            ],
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


