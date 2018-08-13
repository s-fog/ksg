<?php

use common\models\Category;
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
    $actionColumnTemplateString = "{update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
$types = Yii::$app->params['categoryTypes'];
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
                'filter' => Category::getCategoryChain(NULL)
            ],
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


