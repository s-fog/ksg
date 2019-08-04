<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\SurveyForm;
use common\models\Textpage;
use frontend\models\StepOptionChoose;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['name'] = $model->name;

?>

<h1 class="header"><?=$model->step_header?></h1>

<div class="surveyStep">
    <div class="surveyStep__container">
        <div class="surveyStep__header"><?=$model->success_header?></div>
        <div class="surveyStep__optionsHeader"><?=$model->success_text?> <a href="<?=$model->success_link?>" class="linkSpan"><span><?=$model->success_link_text?></span></a> </div>
        <div class="surveyStep__successImage">
            <img src="<?=$model->success_image?>" alt="">
        </div>
        <div class="button_splitWrapper" style="margin-bottom: 80px;">
            <a href="<?=$model->success_link?>" class="button button_split">
                <span class="button_splitText"><?=$model->success_button?></span>
                <span class="button_splitLeft"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"></polygon></g></svg></span>
                <span class="button_splitMiddle"></span>
                <span class="button_splitRight"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 136.84 45.96"><g><polygon points="117.25 0 19.5 0 10.99 0 0 9.1 0 45.96 19.59 45.96 117.34 45.96 125.85 45.96 136.84 36.87 136.84 0 117.25 0"></polygon></g></svg></span>
            </a>
        </div>
    </div>
</div>