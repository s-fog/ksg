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

$breadcrumbs = [
    Url::to(['site/index', 'alias' => $parent->alias]) => $parent->name,
    0 => $model->name
];

?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $breadcrumbs])?>

    <h1><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>

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