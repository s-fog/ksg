<?php

use common\models\Brand;
use common\models\Category;
use common\models\Product;
use common\models\Textpage;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$page = (isset($_GET['page'])) ? $_GET['page'] : '1';
$pagePart = ($page != 1) ? ' - Страница '.$page : '';

if (empty($model->seo_h1)) {
    $h1 = $model->name.$pagePart;
} else {
    $h1 = $model->seo_h1.$pagePart;
}

$this->params['seo_title'] = ($page == 1) ? $h1.' - купите по выгодной цене в интернет-магазине KSG.ru': $h1;
$this->params['seo_description'] = ($page == 1) ? 'Спортивный интернет магазин KSG.ru предлагает купить '.strtolower($h1).' с доставкой по Москве и регионам России. В наличии '.$model->productCount.' моделей по цене от '.$minPrice.' рублей!' : $h1;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;


$childrenCategories = $model->getChildrenCategories();


?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $model->getBreadcrumbs()])?>

<?=$this->render('_filter', [
    'model' => $model,
    'minPrice' => $minPrice,
    'maxPrice' => $maxPrice,
    'filterBrands' => $filterBrands,
])?>

<div class="infs">
    <div class="container">
        <div class="infs__header"><h1><?=$h1?></h1><?=($page == 1) ? "<span>({$model->productCount})</span>" : ''?></div>
        <?php if ($page == 1) {  ?>
            <p class="infs__text"><?=$h1?> по цене от <?=number_format($minPrice, 0, '', ' ')?> руб.! Купите в интернет-магазине KSG.ru и  вы получите фирменную гарантию от производителя, поскольку мы являемся официальным дилером всех брендов представленных на сайте. Доставка по Москве и в регионы России.</p>
        <?php }  ?>
    </div>
</div>

<?=$this->render('@frontend/views/blocks/sort', [
    'childrenCategories' => $childrenCategories
])?>

<div class="catalog">
    <div class="container">
        <div class="catalog__inner">
            <?php
            $productCount = count($products);
            $serials = '<div class="advice__brands">';

            if (!empty($brandsSerial) && $model->type == 2) {
                foreach($brandsSerial as $item) {
                    $serials .= '<a href="'.$item->url.'" class="advice__brandsLink">'.$item->name.'</a>';
                }
            }

            $serials .= '</div>';

            foreach($products as $index => $item) {
                echo $this->render('@frontend/views/catalog/_item', [
                    'model' => $item
                ]);

                if (($index == 2 || (($productCount - 1) == $index && $index < 3)) && !empty($model->text_advice) && !isset($_GET['page'])) {
                    echo '<div class="catalog__item advice">
                            <div class="advice__inner">
                                <div class="advice__header">Совет от KSG</div>
                                <div class="advice__html content">
                                    '.$model->text_advice.'
                                </div>
                                '.$serials.'
                            </div>
                        </div>';
                }
                if (!empty($model->video)) {
                    if (
                    ($productCount > 13 && $index == 12)
                    ||
                    ($productCount <= 13 && $productCount == ($index + 1))
                    ) {
                        echo '<div class="catalog__item newsBlock__item">
                                <div class="newsBlock__itemInner">
                                    <div class="newsBlock__itemImage">
                                        <iframe src="https://www.youtube.com/embed/'.$model->video.'?rel=0&showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                    <div class="newsBlock__itemInfo">
                                        <div class="newsBlock__itemHeader">'.$model->video_header.'</div>
                                    </div>
                                </div>
                            </div>';
                    }
                }
            } ?>
        </div>
    </div>
</div>

<?=LinkPager::widget([
    'pagination' => $pages,
    'disableCurrentPageButton' => true,
    'hideOnSinglePage' => true,
    'maxButtonCount' => 6,
    'firstPageLabel' => '««',
    'lastPageLabel'  => '»»'
]);?>

<?php if ($tags) { ?>
    <div class="category__tags">
        <div class="container">
            <?php foreach($tags as $tag) {
                $url = $tag->url;
                $active = $_SERVER['REQUEST_URI'] == $url;

                if ($active) {?>
                    <span class="category__tag active">
                        <span><?=$tag->name?><?=($tag->productCount != 0) ? " ($tag->productCount)" : ""?></span>
                    </span>
                <?php } else { ?>
                    <a href="<?=$tag->url?>" class="category__tag">
                        <span><?=$tag->name?><?=($tag->productCount != 0) ? " ($tag->productCount)" : ""?></span>
                    </a>
                <?php } ?>
            <?php }
            if (count($tags) > 10) {
                echo '<a href="#" class="category__tagSeeAll"><span>посмотреть все-&gt;</span></a>';
            }
            ?>
        </div>
    </div>
<?php } ?>

<?php if ($years) { ?>
    <div class="category__years">
        <div class="container">
            <span class="category__item">Год:</span>
            <?php foreach($years as $year) {
                $url = $year->url;
                $active = $_SERVER['REQUEST_URI'] == $url;

                if ($active) {?>
                    <span class="category__item link active">
                        <span><?=$year->name?><?=($year->productCount != 0) ? " ($year->productCount)" : ""?></span>
                    </span>
                <?php } else { ?>
                    <a href="<?=$year->url?>" class="category__item link">
                        <span><?=$year->name?><?=($year->productCount != 0) ? " ($year->productCount)" : ""?></span>
                    </a>
                <?php } ?>
            <?php }
            ?>
        </div>
    </div>
<?php } ?>
<?php if (!empty($brands)) { ?>
    <div class="brands">
        <div class="container">
            <h2 class="brands__header"><?=$bHeader?></h2>
            <div class="brands__inner owl-carousel">
                <?php foreach($brands as $brand) {
                    $currentBrand = Brand::findOne($brand->brand_id);

                    if ($currentBrand) {
                        $filename = explode('.', basename($currentBrand->image));
                        ?>
                        <div class="brands__item">
                            <a href="<?=$brand->url?>" class="brands__itemImage"><img src="/images/thumbs/<?=$filename[0]?>-280-140.<?=$filename[1]?>" alt=""></a>
                            <div class="brands__itemText"><?=$currentBrand->description?></div>
                            <a href="<?=$brand->url?>" class="brands__itemLink">
                                <span>смотреть <?=$bHeader2?> <?=$currentBrand->name?> ––></span>
                            </a>
                        </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="brands__list">
            <div class="textBlock">
                <div class="brands__listInner">
                    <?php foreach($brands as $brand) {
                        $url = $brand->url;
                        $active = $_SERVER['REQUEST_URI'] == $url;

                        if ($active) {?>
                            <span class="brands__listItem active">
                                <span><?=$brand->name?><?=($brand->productCount != 0) ? " ($brand->productCount)" : ""?></span>
                            </span>
                        <?php } else { ?>
                            <a href="<?=$url?>" class="brands__listItem">
                                <span><?=$brand->name?><?=($brand->productCount != 0) ? " ($brand->productCount)" : ""?></span>
                            </a>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php foreach($products as $product) {
    echo $this->render('@frontend/views/catalog/_addToCart_items', ['model' => $product]);
} ?>