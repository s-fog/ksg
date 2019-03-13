<?php

use common\models\Brand;
use common\models\Category;
use common\models\Product;
use common\models\Textpage;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$page = (isset($_GET['page'])) ? $_GET['page'] : '1';
$pagePart = ($page != 1) ? ' - Страница '.$page : '';

if ($page != 1) {
    $this->params['canonical'] = Url::canonical();
}

if (empty($model->seo_h1)) {
    $h1 = $model->name.$pagePart;
} else {
    $h1 = $model->seo_h1.$pagePart;
}

$this->params['seo_title'] = ($page == 1) ? $h1.' - купите по выгодной цене в интернет-магазине KSG.ru': $h1;
$this->params['seo_description'] = ($page == 1) ? 'Спортивный интернет магазин KSG.ru предлагает купить '.strtolower($h1).' с доставкой по Москве и регионам России. В наличии '.$model->productCount.' моделей по цене от '.$minPrice.' рублей!' : $h1;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;


$presents = \common\models\Present::find()->all();

?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $model->getBreadcrumbs()])?>

<?=$this->render('@frontend/views/catalog/_filterTop', [
    'model' => $model,
    'minPrice' => $minPrice,
    'maxPrice' => $maxPrice,
    'filterBrands' => $filterBrands,
])?>

<div class="infs">
    <div class="container">
        <div class="infs__header"><h1><?=$model->name?></h1><?=($page == 1) ? "<span>({$model->productCount})</span>" : ''?></div>
        <?php if ($page == 1) {  ?>
            <p class="infs__text"><?=$h1?> по цене от <?=number_format($minPrice, 0, '', ' ')?> руб.! Купите в интернет-магазине KSG.ru и  вы получите фирменную гарантию от производителя, поскольку мы являемся официальным дилером всех брендов представленных на сайте. Доставка по Москве и в регионы России.</p>
        <?php }  ?>
    </div>
    <?=$this->render('@frontend/views/catalog/_filter', [
        'model' => $model,
        'minPrice' => $minPrice,
        'maxPrice' => $maxPrice,
        'filterBrands' => $filterBrands,
    ])?>
</div>

<?=$this->render('@frontend/views/blocks/cats', [
    'inCategories' => $inCategories,
])?>

<div class="catalog">
    <div class="container">
        <div class="catalog__inner">
            <?php
            foreach($products as $index => $item) {
                echo $this->render('@frontend/views/catalog/_item', [
                    'model' => $item
                ]);
            } ?>
        </div>
    </div>
</div>

<?=LinkPager::widget([
    'pagination' => $pages,
    'disableCurrentPageButton' => true,
    'hideOnSinglePage' => true,
    'maxButtonCount' => 6,
    'nextPageLabel' => '&gt;',
    'prevPageLabel' => '&lt;',
    'firstPageLabel' => '&lt;&lt;',
    'lastPageLabel'  => '&gt;&gt;'
]);?>

<?php foreach($products as $product) {
    echo $this->render('@frontend/views/catalog/_addToCart_items', [
        'model' => $product,
        'presents' => $presents,
    ]);
} ?>

<?=$this->render('@frontend/views/blocks/news')?>