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

$this->params['seo_title'] = ($page == 1) ? $h1.' - Официальный сайт дилера': $h1;
$this->params['seo_description'] = ($page == 1) ? 'Заказывайте товары из каталога '.$model->name.' по цене от '.number_format($minPrice, 0, '', ' ').' рублей в интернет-магазине KSG.ru. Доставка по Москве и регионам России.' : $h1;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;


$presents = \common\models\Present::find()->all();

?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $model->getBreadcrumbs()])?>

    <div class="catalogTop">
        <div class="container">
            <div class="catalogTop__inner<?=empty($childrenCategories) ? ' catalogTop__inner_categoriesEmpty' : ''?>">
                <div class="catalogTop__h1<?=empty($childrenCategories) ? ' catalogTop__h1_categoriesEmpty' : ''?>">
                    <h1><?=$h1?></h1>
                    <?=($page == 1) ? "<span>({$model->productCount})</span>" : ''?>
                </div>
                <?=$this->render('@frontend/views/blocks/cats', [
                    'inCategories' => $inCategories,
                    'childrenCategories' => [],
                ])?>
                <select class="catalogTop__sort sort-select" name="sort">
                    <?php if (($model::className() == 'common\models\Brand') ||
                        ($model::className() == 'common\models\Category' && ($model->level === 3 || in_array($model->type, [1, 2, 3, 4])))) { ?>
                        <option value="popular_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'popular_desc') ? ' selected' : ''?>>
                            по популярности</option>
                        <option value="price_asc"<?=((isset($_GET['sort']) && $_GET['sort'] == 'price_asc') || !isset($_GET['sort'])) ? ' selected' : ''?>>
                            сначала дешевле</option>
                        <option value="price_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? ' selected' : ''?>>
                            сначала дороже</option>
                    <?php } else { ?>
                        <option value="popular_desc"<?=((isset($_GET['sort']) && $_GET['sort'] == 'popular_desc') || !isset($_GET['sort'])) ? ' selected' : ''?>>
                            по популярности</option>
                        <option value="price_asc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? ' selected' : ''?>>
                            сначала дешевле</option>
                        <option value="price_desc"<?=(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? ' selected' : ''?>>
                            сначала дороже</option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
    <div class="catalog">
        <div class="container">
            <div class="catalog__inner">
                <div class="catalog__innerLeft">
                    <?=$this->render('@frontend/views/catalog/_filter', [
                        'model' => $model,
                        'minPrice' => $minPrice,
                        'maxPrice' => $maxPrice,
                        'filterBrands' => $filterBrands,
                        'childrenCategories' => false,
                        'filterFeatures' => $filterFeatures,
                    ])?>
                </div>
                <div class="catalog__innerRight">
                    <div class="catalog__innerRightItems">
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
    </div>
</div>


<?php foreach($products as $product) {
    echo $this->render('@frontend/views/catalog/_addToCart_items', [
        'model' => $product,
        'presents' => $presents,
    ]);
} ?>

<?=$this->render('@frontend/views/blocks/news')?>