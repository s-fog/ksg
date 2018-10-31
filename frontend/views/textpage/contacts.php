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
    <div class="container" itemscope itemtype="http://schema.org/Organization">
        <div class="contactsPage__innerMap">
            <div class="contactsPage__innerMapLeft">
                <span itemprop="name" style="display: none;">KSG</span>
                <div class="mainHeader__popupHeader"><?=$city?></div>
                <div class="mainHeader__popupInner">
                    <div class="mainHeader__popupItem">
                        <a href="tel:<?=$moscow['phoneLink']?>" class="mainHeader__popupItemPhone"><span itemprop="telephone"><?=$moscow['phone']?></span></a>
                        <a href="mailto:<?=$moscow['email']?>" class="mainHeader__popupItemEmail"><span itemprop="email"><?=$moscow['email']?></span></a>
                    </div>
                    <div class="mainHeader__popupItem" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                        <div class="mainHeader__popupItemAddress">Адрес: <?=$moscow['addressBrSchema']?></div>
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
            <div class="contactsPage__innerMapRight">
                <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Abef919c4ad6a43d9cc114707a77ab5471d01c6b3207424d574005763edfa115b&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=false"></script>
            </div>
        </div>
    </div>
</div>
