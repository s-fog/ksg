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

?>

<?=$this->render('@frontend/views/blocks/brands')?>

<div class="alphabet">
    <div class="container">
        <div class="alphabet__header">Алфавитный список брендов</div>
        <div class="alphabet__tabs">
            <?php foreach($result as $letter => $notUse) { ?>
                <div class="alphabet__tab" data-id="<?=$letter?>"><?=$letter?></div>
            <?php } ?>
        </div>
        <div class="alphabet__contents">
            <?php foreach($result as $letter => $notUse) { ?>
                <div class="alphabet__content" data-id="<?=$letter?>">
                    <div class="alphabet__contentHeader"><?=$letter?></div>
                    <div class="brands__listInner">
                        <?php foreach($result[$letter] as $brand) { ?>
                            <a href="<?=$brand->url?>" class="brands__listItem"><span><?=$brand->name?></span></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
