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
    0 => $model->name
];

?>

<?=$this->render('@frontend/views/blocks/breadcrumbs', ['items' => $breadcrumbs])?>

    <h1><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>

    <div class="newsBlock">
        <div class="container">
            <div class="newsBlock__inner">
                <?php foreach($news as $item) {
                    echo $this->render('@frontend/views/news/_item', [
                        'model' => $item,
                        'parent' => $model
                    ]);
                } ?>
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