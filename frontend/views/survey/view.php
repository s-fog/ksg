<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\Textpage;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['name'] = $model->name;

?>

<h1 class="header"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>

<div class="survey">
    <div class="container">
        <div class="survey__header"><?=$model->under_header?></div>
    </div>
    <div class="survey__video">
        <div class="survey__videoBg"></div>
        <div class="survey__iframe">
            <iframe src="https://www.youtube.com/embed/<?=$model->youtube?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="survey__videoText"><?=$model->youtube_text?></div>
        <a href="#" class="button button3 survey__videoButton">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 227.88 40.99"><g><polygon points="9.8 0 0 8.11 0 40.99 218.07 40.99 227.88 32.88 227.88 0 9.8 0"></polygon></g></svg>
            <span><?=$model->button_text?></span>
        </a>
    </div>
    <div class="survey__items">
        <div class="survey__itemsColumn">
            <?php
            $limit = floor(count($model->steps) / 2);

            for($i = 0; $i < $limit; $i++) {
                echo $this->render('@frontend/views/survey/_stepItem', [
                    'model' => $model->steps[$i],
                    'index' => $i,
                ]);
            } ?>
        </div>
        <div class="survey__itemsColumn">
            <?php
            for($i = $limit; $i < count($model->steps); $i++) {
                echo $this->render('@frontend/views/survey/_stepItem', [
                    'model' => $model->steps[$i],
                    'index' => $i,
                ]);
            } ?>
        </div>
    </div>
    <div class="survey__cupon">
        <div class="survey__cuponContainer">
            <div class="survey__cuponHeader"><?=$model->cupon_header?></div>
            <div class="survey__cuponText"><?=$model->cupon_text?></div>
            <div class="button button1 survey__cuponButton">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"></polygon></g></g></svg>
                <span><?=$model->cupon_button?></span>
            </div>
            <img class="survey__cuponImage" src="<?=$model->cupon_image?>">
        </div>
    </div>
</div>