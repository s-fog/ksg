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

$childrenCategories = $model->getChildrenCategories();
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
                'childrenCategories' => $childrenCategories,
                'inCategories' => $inCategories,
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
                <?=$this->render('_filter', [
                    'model' => $model,
                    'minPrice' => $minPrice,
                    'maxPrice' => $maxPrice,
                    'filterBrands' => $filterBrands,
                    'childrenCategories' => $childrenCategories,
                    'filterFeatures' => $filterFeatures,
                ])?>
            </div>
            <div class="catalog__innerRight">
                <div class="catalog__innerRightItems">
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
    </div>
</div>

<?php if ($tags) { ?>
    <div class="category__tags">
        <div class="container">
            <?php foreach($tags as $tag) {
                $url = $tag->url;
                $active = $_SERVER['REQUEST_URI'] == $url;
                $productCount = $tag->productCount;

                if ($active) {?>
                    <span class="category__tag active">
                        <span><?=$tag->name?><?=($productCount != 0) ? " ($productCount)" : ""?></span>
                    </span>
                <?php } else { ?>
                    <a href="<?=$tag->url?>" class="category__tag">
                        <span><?=$tag->name?><?=($productCount != 0) ? " ($productCount)" : ""?></span>
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
                $productCount = $year->productCount;

                if ($active) {?>
                    <span class="category__item link active">
                        <span><?=$year->name?><?=($productCount != 0) ? " ($productCount)" : ""?></span>
                    </span>
                <?php } else { ?>
                    <a href="<?=$year->url?>" class="category__item link">
                        <span><?=$year->name?><?=($productCount != 0) ? " ($productCount)" : ""?></span>
                    </a>
                <?php } ?>
            <?php }
            ?>
        </div>
    </div>
<?php } ?>

    <div class="catalogSeoText">
        <p class="container">
            <?=$h1?> по цене от <?=number_format($minPrice, 0, '', ' ')?> руб.! Купите в интернет-магазине KSG.ru и  вы получите фирменную гарантию от производителя, поскольку мы являемся официальным дилером всех брендов представленных на сайте. <br>
            Доставка по Москве и в регионы России.
        </p>
    </div>

    <?php if (!empty($model->steps)) { ?>
        <div class="survey__items">
            <div class="survey__itemsColumn">
                <?php foreach($model->steps as $index => $step) {
                    if ($index % 2 === 0) {
                        echo $this->render('@frontend/views/survey/_stepItem', [
                            'model' => $step,
                            'index' => $index,
                        ]);
                    }
                } ?>
            </div>
            <div class="survey__itemsColumn">
                <?php foreach($model->steps as $index => $step) {
                    if ($index % 2 !== 0) {
                        echo $this->render('@frontend/views/survey/_stepItem', [
                            'model' => $step,
                            'index' => $index,
                        ]);
                    }
                } ?>
            </div>
        </div>
    <?php } ?>

<?php if (!empty($brandCategories)) { ?>
    <div class="brands">
        <div class="container">
            <h2 class="brands__header"><?=$bHeader?></h2>
            <div class="brands__inner owl-carousel">
                <?php foreach($brandCategories as $brandCategory) {
                    $currentBrand = $brandCategory->brand;

                    if ($currentBrand) {
                        $filename = explode('.', basename($currentBrand->image));
                        ?>
                        <div class="brands__item">
                            <a href="<?=$brandCategory->url?>" class="brands__itemImage"><img src="/images/thumbs/<?=$filename[0]?>-280-140.<?=$filename[1]?>" alt=""></a>
                            <div class="brands__itemText"><?=$currentBrand->description?></div>
                            <a href="<?=$brandCategory->url?>" class="brands__itemLink">
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
                    <?php foreach($brandCategories as $brandCategory) {
                        $url = $brandCategory->url;
                        $active = $_SERVER['REQUEST_URI'] == $url;
                        $productCount = $brandCategory->productCount;

                        if ($active) {?>
                            <span class="brands__listItem active">
                                <span><?=$brandCategory->name?><?=($productCount != 0) ? " ($productCount)" : ""?></span>
                            </span>
                        <?php } else { ?>
                            <a href="<?=$url?>" class="brands__listItem">
                                <span><?=$brandCategory->name?><?=($productCount != 0) ? " ($productCount)" : ""?></span>
                            </a>
                        <?php } ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>


<?php foreach($products as $product) {
    echo $this->render('@frontend/views/catalog/_addToCart_items', [
        'model' => $product,
        'presents' => $presents,
    ]);
} ?>

<?=$this->render('@frontend/views/blocks/news')?>