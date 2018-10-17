<?php
use frontend\models\Favourite;
use yii\widgets\LinkPager;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;
$this->params['seo_h1'] = $model->seo_h1;


?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => [0 => $model->name]])?>

<h1 class="header"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>

<?php if (!empty($products)) { ?>
    <?=$this->render('@frontend/views/blocks/sort', [
        'model' => $model
    ])?>

    <div class="catalog">
        <div class="container">
            <div class="catalog__inner">
                <?php
                foreach($products as $index => $item) {
                    echo $this->render('@frontend/views/catalog/_item', [
                        'model' => $item,
                        'favourite' => true
                    ]);
                }
                ?>
            </div>
        </div>
    </div>

    <?=LinkPager::widget([
        'pagination' => $pages,
        'disableCurrentPageButton' => true,
        'hideOnSinglePage' => true,
        'maxButtonCount' => 6
    ]);?>

    <?php foreach($products as $product) {
        echo $this->render('@frontend/views/catalog/_addToCart_items', ['model' => $product]);
    } ?>
<?php } else { ?>
    <div class="empty">
        <div class="container">
            <div class="empty__inner">
                <div class="empty__left" style="height: 146px;background-image: url(/img/favouriteEmpty.png);"></div>
                <div class="empty__right">
                    <div class="empty__header">К избранному не добавлено товаров</div>
                    <div class="empty__text">В избранном мы сохраняем товары, которые Вам интересны. Для того, чтобы добавить товар в эту вкладку, просто нажмите на иконку сердечка в правом верхнем углу любой карточки товара на нашем сайте.</div>
                    <a href="/catalog" class="empty__link">Перейти в каталог</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

