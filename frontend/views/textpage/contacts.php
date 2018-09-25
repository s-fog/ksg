<?php

use common\models\Brand;
use common\models\Mainslider;
use common\models\Product;
use common\models\Textpage;
use frontend\models\City;
use yii\helpers\Url;

$this->params['seo_title'] = $model->seo_title;
$this->params['seo_description'] = $model->seo_description;
$this->params['seo_keywords'] = $model->seo_keywords;
$this->params['name'] = $model->name;

$city = 'Москва';
$array = Yii::$app->params['cities'];
$moscow = $array['Москва'];
$others = $array['Others'];

?>

<div class="contactsPage">
    <div class="container">
        <div class="mainHeader__popupHeader"><?=$city?></div>
        <div class="mainHeader__popupInner">
            <div class="mainHeader__popupItem">
                <a href="tel:<?=$moscow['phoneLink']?>" class="mainHeader__popupItemPhone"><span><?=$moscow['phone']?></span></a>
                <a href="mailto:<?=$moscow['email']?>" class="mainHeader__popupItemEmail"><span><?=$moscow['email']?></span></a>
            </div>
            <div class="mainHeader__popupItem">
                <div class="mainHeader__popupItemAddress">Адрес: <?=$moscow['addressBr']?></div>
            </div>
        </div>
        <div class="mainHeader__popupInner">
            <div class="mainHeader__popupItem">
                <div class="mainHeader__popupItemHeader">Для регионов</div>
                <a href="tel:<?=$others['phoneLink']?>" class="mainHeader__popupItemPhone"><span><?=$others['phone']?></span></a>
                <a href="mailto:<?=$others['email']?>" class="mainHeader__popupItemEmail"><span><?=$others['email']?></span></a>
            </div>
        </div>
    </div>
</div>
