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
    <?php if (!$empty) { ?>
        <div class="properties__tabs">
            <?php
            $active1 = '';
            $active2 = '';

            if (!empty($products) && !empty($stati)) {
                $active1 = ' active';
            }

            if (empty($products) && !empty($stati)) {
                $active2 = ' active';
            }

            if (!empty($products) && empty($stati)) {
                $active1 = ' active';
            }

            if (!empty($products)) {
                echo '<div class="properties__tab'.$active1.'"><span>Товары('.$productsCount.')</span></div>';
            }

            if (!empty($stati)) {
                echo '<div class="properties__tab'.$active2.'"><span>Статьи('.count($stati).')</span></div>';
            }
            ?>
            <svg class="properties__tabUnderline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 89 7.7"><defs></defs><g><polygon points="1.7 0 0 1.4 0 3 39.7 3 44.5 7.7 49.3 3 87.3 3 89 1.5 89 0 1.7 0"></polygon></g></svg>
        </div>
    <?php } ?>
</div>

<?php if ($empty) { ?>
    <div class="container content">
        <p>Ничего не найдено</p>
    </div>
<?php } else { ?>
    <div class="properties__contents properties__contents_search">
        <?php if (!empty($products)) { ?>
            <div class="properties__content<?=$active1?>">
                <div class="catalog">
                    <div class="container">
                        <div class="catalog__inner">
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
            </div>
        <?php } ?>
        <?php if (!empty($stati)) {
            $newsPage = Textpage::findOne(13);
            ?>
            <div class="properties__content<?=$active2?>">
                <div class="newsBlock">
                    <div class="container">
                        <div class="newsBlock__inner">
                            <?php foreach($stati as $item) {
                                echo $this->render('@frontend/views/news/_item', [
                                    'model' => $item,
                                    'parent' => $newsPage
                                ]);
                            } ?>
                        </div>
                        <div class="wantMore">
                            <div class="wantMore__text">Не нашли нужное? Попробуйте</div>
                            <a href="<?=Url::to(['site/index', 'alias' => $newsPage->alias])?>" class="button button3 wantMore__toCatalog">
                                <span>Перейти в наш блог</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 227.88 40.99"><g><polygon points="9.8 0 0 8.11 0 40.99 218.07 40.99 227.88 32.88 227.88 0 9.8 0"/></g></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<br>
<br>
<br>

