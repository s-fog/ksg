<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\Survey;
use common\models\Textpage;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;

$surveys = Survey::find()->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])->all();

?>

<div class="newsBlock">
    <div class="container">
        <div class="newsBlock__inner">
            <?php foreach($surveys as $survey) {
                $filename = explode('.', basename($survey->preview_image));
                ?>
                <div class="newsBlock__item">
                    <a href="<?=$survey->url?>" class="newsBlock__itemImage" style="background-image: url(/images/thumbs/<?=$filename[0]?>-260-150.<?=$filename[1]?>);">
                        <span class="newsBlock__itemRead"><span>Подобрать</span></span>
                    </a>
                    <div class="newsBlock__itemInfo">
                        <a href="<?=$survey->url?>" class="newsBlock__itemHeader"><span><?=$survey->name?></span></a>
                        <div class="newsBlock__itemText"><?=$survey->introtext?></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>