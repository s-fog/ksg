<?php

use common\models\Category;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use himiklab\sortablegrid\SortableGridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var common\models\CategorySearch $searchModel
*/
$this->title = Yii::t('models', 'Categories');

if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Создать', ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{update}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
$types = Yii::$app->params['categoryTypes'];

$gridType = 0;
if (
    isset($_GET['CategorySearch']['parent_id'])
    &&
    (!empty($_GET['CategorySearch']['parent_id']) || $_GET['CategorySearch']['parent_id'] == 0)
    &&
    isset($_GET['CategorySearch']['type'])
    &&
    $_GET['CategorySearch']['type'] == 0
) {
    $gridType = 1;
}
?>
<div class="giiant-crud category-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', 'Categories') ?>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . 'Создать', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

    </div>

    <hr />

    <div class="table-responsive">
        <?php
        $opts = [
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
                'alias',
                [
                    'attribute' => 'type',
                    'content' => function($data) use ($types) {
                        return $types[$data->type];
                    },
                    'filter' => $types
                ],
                [
                    'attribute' => 'parent_id',
                    'content' => function($data) {
                        $parent = Category::findOne($data->parent_id);

                        if (!$parent) {
                            return 'Нет родителя';
                        } else {
                            return $parent->chain;
                        }
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'parent_id',
                        'data' => Category::getCategoryChain(NULL),
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
                    'attribute'=>'active',
                    'label'=>'Активна?',
                    'format'=>'html',
                    'content'=>function($data){
                        if (!empty($data->active)) {
                            return "<div style='text-align: center;'><img src='/img/icon_02.png' alt=''></div>";
                        } else {
                            return "<div style='text-align: center;'><img src='/img/icon_01.png' alt=''></div>";
                        }
                    },
                    'filter' => [
                        '0' => 'Не активна',
                        '1' => 'Активна'
                    ]
                ],
            ],
        ];
        if ($gridType == 0) { ?>
            <?= GridView::widget($opts); ?>
        <?php } else { ?>
            <?= SortableGridView::widget($opts); ?>
        <?php } ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


