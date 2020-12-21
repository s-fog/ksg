<?php

use common\models\Supplier;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use himiklab\sortablegrid\SortableGridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var common\models\ProductSearch $searchModel
*/

$this->title = Yii::t('models', 'Products');

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Создать', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{clone} {delete} {update}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud product-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>
    
    <div class="btn btn-primary" id="disallow_yandex">Запретить выгрузку в Yandex всех товаров</div>
    <div class="btn btn-primary" id="allow_yandex">Разрешить выгрузку в Yandex всех товаров</div>

    <?php
    $script = <<< JS
        $('#disallow_yandex').click(function() {
            confirm('Вы уверены?');
            
            $.get('/officeback/ajax/disallow-yandex-products', function() {
                alert('Готово');
            })
        });

        $('#allow_yandex').click(function() {
            confirm('Вы уверены?');
            
            $.get('/officeback/ajax/allow-yandex-products', function() {
                alert('Готово');
            })
        });
JS;
    $this->registerJs($script);
    ?>
    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', 'Products') ?>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Создать', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

    </div>

    <hr />

    <div class="table-responsive">
        <?= SortableGridView::widget([
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
                'clone' => function ($url, $model, $key) {
                    $options = [
                            'style' => 'font-size: 1.6rem'
                    ];
                    return Html::a('<span class="glyphicon glyphicon-duplicate"></span>', $url, $options);
                },
                'view' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('cruds', 'View'),
                        'aria-label' => Yii::t('cruds', 'View'),
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
			'name',
			'price',
           [
                'attribute' => 'available',
                'label' => 'Наличие',
                'content' => function($data) {
                    return !empty($data->productParams) ? $data->productParams[0]->available : '';
                }
            ],
           [
                'attribute' => 'ppArtikul',
                'label' => 'Артикул',
                'content' => function($data) {
                    $return = [];

                    foreach($data->productParams as $pp) {
                        $return[] = $pp->artikul;
                    }

                    return implode(',', $return);
                }
            ],
            [
                'attribute' => 'supplierName',
                'label' => 'Поставщик',
                'content' => function($data) {
                    return $data->supplierModel->name;
                },
                'filter' => ArrayHelper::map(Supplier::find()->all(), 'id', 'name')
            ],
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


