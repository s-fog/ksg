<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\Textpage;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;
$this->params['seo_h1'] = $model->seo_h1;

if (isset($parent)) {
    $breadcrumbs = [
        Url::to(['site/index', 'alias' => $parent->alias]) => $parent->name,
        0 => $model->name
    ];
} else {
    $breadcrumbs = [
        0 => $model->name
    ];
}

?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $breadcrumbs])?>

    <div class="infs">
        <div class="container">
            <h1 class="infs__header"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>
            <div class="infs__tabs">
                <?php foreach($textpages as $textpage) {
                    if (isset($parent)) {
                        $url = Url::to(['site/index', 'alias' => $parent->alias, 'alias2' => $textpage->alias]);
                    } else {
                        $url = Url::to(['site/index', 'alias' => $model->alias, 'alias2' => $textpage->alias]);
                    }

                    $active = $_SERVER['REQUEST_URI'] == $url;
                    ?>
                    <a href="<?=$url?>" class="infs__tab<?=($active) ? ' active' : ''?>"><span><?=$textpage->name?></span></a>
                <?php } ?>
            </div>
        </div>
    </div>

<?php if (!empty($model->html)) { ?>
    <div class="textBlock">
        <div class="content columns">
            <?=$model->html?>
        </div>
    </div>
<?php } ?>

<?php if (!empty($model->html2)) { ?>
    <div class="textBlock">
        <div class="content">
            <?=$model->html2?>
        </div>
    </div>
<?php } ?>

<?=$this->render('@frontend/views/blocks/news')?>