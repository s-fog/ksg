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

$this->params['seo_title'] = $model->name.' - Официальный сайт дилера';
$this->params['seo_description'] = 'Заказывайте товары из каталога '.$model->name.' по цене от '.number_format($minPrice, 0, '', ' ').' рублей в интернет-магазине KSG.ru. Доставка по Москве и регионам России.';
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
            <p class="infs__text">
                В каталоге представлены товары бренда <?=$model->name?> по цене от <?=number_format($minPrice, 0, '', ' ')?> рублей! Интернет-магазин KSG - официальный дилер <?=$model->name?> в России, покупая у нас вы получаете фирменную гарантию от производителя. Доставка по Москве и регионам РФ.
            </p>
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