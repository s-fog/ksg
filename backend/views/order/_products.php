<?php
use common\models\Product;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$products = unserialize(base64_decode($order->products));

foreach($products as $product) {
    $product->quantity = $product->getQuantity();
    $product->link = Url::to(['product/update', 'id' => $product->id]);
}
?>

<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $products
    ]),
    'columns' => [
        'id',
        'name',
        'quantity',
        [
            'label' => 'Ссылка на товар',
            'format' => 'raw',
            'value' => function ($data) {
                return "<a href='$data->link' target='_blank'>$data->name</a>";
            }
        ],
        /*[
            'class' => 'yii\grid\ActionColumn',
            'template' => "{delete}",
            'buttons' => [
                'delete' => function ($url, $model, $key) use ($order) {
                    $options = [
                        'title' => 'Удалить товар',
                        'aria-label' => 'Удалить товар',
                        'data-pjax' => '0',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-remove"></span>', Url::to(['order/product-delete', 'order_id' => $order->id, 'id' => $model->getId()]), $options);
                }
            ],
            'urlCreator' => function($action, $model, $key, $index) {
                // using the column name as key, not mapping to 'id' like the standard generator
                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                return Url::toRoute($params);
            },
            'contentOptions' => ['nowrap'=>'nowrap']
        ]*/
    ],
    'layout'=>"{items}",
]); ?>