<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\Textpage;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;

$presents = \common\models\Present::find()->all();

?>

<div class="searchPage">
    <div class="container">
        <h1 class="infs__header">Поиск</h1>
        <form action="<?=Url::to(['site/index', 'alias' => Textpage::findOne(15)->alias])?>" method="GET" class="search">
            <div class="form-group">
                <input type="text" name="query" class="search__input" placeholder="найти в каталоге" value="<?=$query?>">
            </div>
            <button class="search__submit" type="submit">
                <svg data-popup="search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30.77 30"><g><path d="M19.47,0a11.3,11.3,0,1,0,11.3,11.3A11.35,11.35,0,0,0,19.47,0Zm0,19.9A8.5,8.5,0,1,1,28,11.4,8.49,8.49,0,0,1,19.47,19.9Z"></path><path d="M19.47,4.4a1.37,1.37,0,0,0-1.4,1.4,1.37,1.37,0,0,0,1.4,1.4,4.23,4.23,0,0,1,4.2,4.2,1.41,1.41,0,0,0,2.81,0A7,7,0,0,0,19.47,4.4Z"></path><path d="M7.67,20.3.38,27.6a1.5,1.5,0,0,0,0,2,1.26,1.26,0,0,0,1,.4,1.28,1.28,0,0,0,1-.4l7.29-7.3a1.52,1.52,0,0,0,0-2A1.52,1.52,0,0,0,7.67,20.3Z"></path></g></svg>
            </button>
        </form>
    </div>
</div>

<?php if ($empty) { ?>
    <div class="container content">
        <p>Ничего не найдено</p>
    </div>
<?php } else { ?>
    <div class="properties__contents properties__contents_search">
        <br>
        <?php if (!empty($categories)) { ?>
            <div class="container">
                <div class="catalogTop__h1">
                    <h1>НАЙДЕНО В КАТЕГОРИЯХ:</h1>
                </div>
                <div class="category__slider owl-carousel">
                    <?php foreach($categories as $category) {
                        $filename = explode('.', basename($category->image_menu));

                        if (empty($filename[1])) {
                            $filename[1] = '';
                        }
                        ?>
                        <a href="<?=$category->url?>" class="category__sliderItem">
                            <span class="category__sliderItemImage" style="background-image: url(/images/thumbs/<?=$filename[0]?>-134-134.<?=$filename[1]?>);"></span>
                            <span class="category__sliderItemName"><span><?=$category->name?></span></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($products)) { ?>
            <div class="catalogTop__h1">
                <div class="container">
                    <h1>НАЙДЕНО В ТОВАРАХ:</h1>
                </div>
            </div>
            <div class="catalog">
                <div class="container">
                    <div class="catalog__inner catalog__inner_search">
                        <?php foreach($products as $product) {
                            echo $this->render('@frontend/views/catalog/_item', [
                                'model' => $product
                            ]);
                        } ?>
                    </div>
                    <?=LinkPager::widget([
                        'pagination' => $pages,
                        'disableCurrentPageButton' => true,
                        'hideOnSinglePage' => true,
                        'maxButtonCount' => 6,
                        'firstPageLabel' => '««',
                        'lastPageLabel'  => '»»'
                    ]);?>
                    <div class="wantMore">
                        <div class="wantMore__text">Не нашли нужное? Попробуйте</div>
                        <a href="<?=Url::to(['site/index', 'alias' => Textpage::findOne(1)->alias])?>" class="button button3 wantMore__toCatalog">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 227.88 40.99"><g><polygon points="9.8 0 0 8.11 0 40.99 218.07 40.99 227.88 32.88 227.88 0 9.8 0"/></g></svg>
                            <span>Перейти в каталог</span>
                        </a>
                    </div>
                </div>
            </div>

            <?php foreach($products as $product) {
                echo $this->render('@frontend/views/catalog/_addToCart_items', [
                    'model' => $product,
                    'presents' => $presents,
                ]);
            } ?>
        <?php } ?>
    </div>
<?php } ?>
<br>
<br>
<br>

