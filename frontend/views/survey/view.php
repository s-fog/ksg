<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\Textpage;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['name'] = $model->name;

$firstUrl = Url::to([
    'site/index',
    'alias' => Textpage::getSurveyPage()->alias,
    'alias2' => $model->alias,
    'step' => 1,
])

?>

<h1 class="header"><?=empty($model->seo_h1) ? $model->name : $model->seo_h1?></h1>

<div class="survey">
    <div class="container">
        <div class="survey__header"><?=$model->under_header?></div>
    </div>
    <div class="survey__video">
        <div class="survey__videoBg"></div>
        <div class="survey__iframe">
            <?php if (empty($model->youtube)) { ?>
                <img src="<?=$model->success_image?>" alt="">
            <?php } else { ?>
                <iframe src="https://www.youtube.com/embed/<?=$model->youtube?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <?php } ?>
        </div>
        <div class="survey__videoText"><?=$model->youtube_text?></div>
        <a href="<?=$firstUrl?>" class="button button3 survey__videoButton">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 227.88 40.99"><g><polygon points="9.8 0 0 8.11 0 40.99 218.07 40.99 227.88 32.88 227.88 0 9.8 0"></polygon></g></svg>
            <span><?=$model->button_text?></span>
        </a>
    </div>
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
    <div class="survey__items survey__items_mobile">
        <?php foreach($model->steps as $index => $step) {
            echo $this->render('@frontend/views/survey/_stepItem', [
                'model' => $step,
                'index' => $index,
            ]);
        } ?>
    </div>
    <div class="button_splitWrapper" style="margin-top: -45px;">
        <a href="<?=$firstUrl?>" class="button button_split survey__moreButton">
            <span class="button_splitText"><?=$model->button2_text?></span>
            <span class="button_splitLeft"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"></polygon></g></svg></span>
            <span class="button_splitMiddle"></span>
            <span class="button_splitRight"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"></polygon></g></svg></span>
        </a>
    </div>
    <div class="survey__cupon">
        <div class="survey__cuponContainer">
            <div class="survey__cuponHeader"><?=$model->cupon_header?></div>
            <div class="survey__cuponText"><?=$model->cupon_text?></div>
            <a href="<?=$firstUrl?>" class="button button1 survey__cuponButton">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"></polygon></g></g></svg>
                <span><?=$model->cupon_button?></span>
            </a>
            <img class="survey__cuponImage" src="<?=$model->cupon_image?>">
        </div>
    </div>
</div>