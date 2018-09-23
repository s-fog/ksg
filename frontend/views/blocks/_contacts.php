<?php

use frontend\models\City;

$city = City::getCity();
$array = Yii::$app->params['cities'];
$moscow = $array['Москва'];
$others = $array['Others'];

?>

<?php if ($city == 'Москва') { ?>
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
<?php } else { ?>
    <div class="mainHeader__popupHeader"><?=$city?></div>
    <div class="mainHeader__popupInner">
        <div class="mainHeader__popupItem">
            <a href="tel:<?=$others['phoneLink']?>" class="mainHeader__popupItemPhone"><span><?=$others['phone']?></span></a>
            <a href="mailto:<?=$others['email']?>" class="mainHeader__popupItemEmail"><span><?=$others['email']?></span></a>
        </div>
    </div>
    <div class="mainHeader__popupInner">
        <div class="mainHeader__popupItem">
            <div class="mainHeader__popupItemHeader">Москва</div>
            <a href="tel:<?=$moscow['phoneLink']?>" class="mainHeader__popupItemPhone"><span><?=$moscow['phone']?></span></a>
            <a href="mailto:<?=$moscow['email']?>" class="mainHeader__popupItemEmail"><span><?=$moscow['email']?></span></a>
        </div>
        <div class="mainHeader__popupItem">
            <div class="mainHeader__popupItemAddress" style="margin: 52px 0 0 0;">Адрес: <?=$moscow['addressBr']?></div>
        </div>
    </div>
<?php } ?>

<div class="button button1 callbackButton" data-fancybox data-src="#callback">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.08 17.94"><g><g><polygon points="4.01 0.5 0.5 3.41 0.5 17.44 95.07 17.44 98.58 14.53 98.58 0.5 4.01 0.5"/></g></g></svg>
    <span>заказать обратный звонок</span>
</div>