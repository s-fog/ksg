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

<?=$this->render('@frontend/views/blocks/sort')?>

<?php if (!empty($products)) { ?>
    <div class="catalog">
        <div class="container">
            <div class="catalog__inner">
                <?php
                foreach($products as $index => $item) {
                    echo $this->render('@frontend/views/catalog/_item', [
                        'model' => $item
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
<?php } else { ?>
    <div class="container">
        <p>Вы ничего не добавили</p>
    </div>
<?php } ?>

